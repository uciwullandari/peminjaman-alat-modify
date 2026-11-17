<?php

namespace App\Services;

use App\Enums\StatusPeminjaman;
use App\Models\DetailPeminjaman;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianService
{
    public function antrianVerifikasi()
    {
        return Peminjaman::with([
            'peminjam',
            'detail.alat'
        ])
            ->where(
                'status',
                StatusPeminjaman::MenungguVerifikasi->value
            )
            ->orderBy('tgl_diajukan_kembali')
            ->paginate(10);
    }

    public function daftarSedangDipinjam()
    {
        return Peminjaman::with([
            'peminjam',
            'detail.alat'
        ])
            ->whereIn('status', [
                StatusPeminjaman::Dipinjam->value,
                StatusPeminjaman::MenungguVerifikasi->value,
            ])
            ->orderBy('tgl_harus_kembali')
            ->paginate(10);
    }

    public function verifikasi(
        Peminjaman $peminjaman,
        int $petugasId,
        array $kondisiPerBaris,
        string $tglKembali,
        float $dendaKerusakan,
        ?string $catatan = null
    ): Pengembalian {
        /*
        |--------------------------------------------------------------------------
        | Pastikan status masih menunggu verifikasi
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $peminjaman->status->bolehKe(
                StatusPeminjaman::Selesai
            ),
            422,
            'Peminjaman ini belum diajukan untuk dikembalikan.'
        );

        /*
        |--------------------------------------------------------------------------
        | Hitung Denda Keterlambatan Otomatis
        |--------------------------------------------------------------------------
        */
        $tglHarusKembali = Carbon::parse($peminjaman->tgl_harus_kembali);
        $tglKembaliAktual = Carbon::parse($tglKembali);

        $hariTerlambat = 0;
        $dendaKeterlambatan = 0;

        if ($tglKembaliAktual->greaterThan($tglHarusKembali)) {
            $hariTerlambat = $tglHarusKembali->diffInDays($tglKembaliAktual);
            $tarifDendaPerHari = (float) Pengaturan::ambil('tarif_denda_harian', 0);
            $dendaKeterlambatan = $hariTerlambat * $tarifDendaPerHari;
        }

        $totalDenda = $dendaKeterlambatan + $dendaKerusakan;

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Simpan kondisi alat saat dikembalikan
            |--------------------------------------------------------------------------
            */

            foreach ($kondisiPerBaris as $detailId => $kondisi) {

                $detail = DetailPeminjaman::with('alat')
                    ->where('id', $detailId)
                    ->where(
                        'peminjaman_id',
                        $peminjaman->id
                    )
                    ->firstOrFail();

                $detail->update([
                    'kondisi_kembali' => $kondisi,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Catat koreksi tanggal kembali
            |--------------------------------------------------------------------------
            */

            $tglDiajukan =
                $peminjaman->tgl_diajukan_kembali?->toDateString();

            if (
                $tglDiajukan &&
                $tglDiajukan !== $tglKembali
            ) {
                LogAktivitas::create([
                    'user_id' => $petugasId,
                    'aksi' => 'koreksi_tgl_kembali',
                    'tabel_tujuan' => 'pengembalian',
                    'deskripsi' =>
                        'Tanggal kembali ' .
                        $peminjaman->kode_pinjam .
                        ' dikoreksi dari ' .
                        $tglDiajukan .
                        ' menjadi ' .
                        $tglKembali,
                    'ip_address' => request()->ip(),
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan data pengembalian dengan denda terhitung otomatis
            |--------------------------------------------------------------------------
            */

            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'petugas_id' => $petugasId,
                'tgl_kembali' => $tglKembali,
                'hari_terlambat' => $hariTerlambat,
                'denda_keterlambatan' => $dendaKeterlambatan,
                'denda_kerusakan' => $dendaKerusakan,
                'total_denda' => $totalDenda,
                'catatan' => $catatan,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Ubah status peminjaman menjadi SELESAI
            |--------------------------------------------------------------------------
            */

            $peminjaman->update([
                'status' => StatusPeminjaman::Selesai->value,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Catat aktivitas verifikasi pengembalian
            |--------------------------------------------------------------------------
            */

            LogAktivitas::create([
                'user_id' => $petugasId,
                'aksi' => 'verifikasi_pengembalian',
                'tabel_tujuan' => 'pengembalian',
                'deskripsi' =>
                    'Memverifikasi pengembalian ' .
                    $peminjaman->kode_pinjam,
                'ip_address' => request()->ip(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Commit transaksi
            |--------------------------------------------------------------------------
            */

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil ulang data pengembalian
        |--------------------------------------------------------------------------
        */

        return $pengembalian->fresh([
            'peminjaman',
            'petugas',
        ]);
    }
}
