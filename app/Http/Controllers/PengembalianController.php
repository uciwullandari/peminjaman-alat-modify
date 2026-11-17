<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Services\PeminjamanService;
use App\Services\PengembalianService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function __construct(
        private PengembalianService $layanan,
        private PeminjamanService $layananPeminjaman
    ) {}

    // Method untuk menampilkan halaman daftar koreksi pengembalian
    public function daftarKoreksi()
    {
        $pengembalians = Pengembalian::with(['peminjaman.peminjam'])->latest()->get();

        return view('koreksi.pengembalian-daftar', compact('pengembalians'));
    }

    // Method untuk menampilkan form ubah/koreksi pengembalian
    public function ubah(Pengembalian $pengembalian)
    {
        $pengembalian->load('peminjaman.peminjam');
        return view('koreksi.pengembalian-ubah', compact('pengembalian'));
    }

    // Method untuk menyimpan pembaruan koreksi pengembalian
    public function update(Request $request, Pengembalian $pengembalian)
    {
        $request->validate([
            'denda_kerusakan' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $dendaKerusakanBaru = $request->denda_kerusakan;
        $dendaKeterlambatan = $pengembalian->denda_keterlambatan;
        $totalDendaBaru = $dendaKeterlambatan + $dendaKerusakanBaru;

        $pengembalian->update([
            'denda_kerusakan' => $dendaKerusakanBaru,
            'total_denda' => $totalDendaBaru,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('koreksi.pengembalian.daftar')->with('sukses', 'Data pengembalian berhasil dikoreksi.');
    }

    public function ajukan(Peminjaman $peminjaman)
    {
        abort_unless(
            $peminjaman->user_id === Auth::id(),
            403
        );

        $this->layananPeminjaman->ajukanPengembalian($peminjaman);

        return redirect()
            ->route('peminjaman.saya')
            ->with(
                'sukses',
                'Pengembalian ' .
                $peminjaman->kode_pinjam .
                ' diajukan. Menunggu verifikasi petugas.'
            );
    }

    public function pantau()
    {
        $daftarPeminjaman =
            $this->layanan->daftarSedangDipinjam();

        return view(
            'pengembalian.pantau',
            compact('daftarPeminjaman')
        );
    }

    public function antrian()
    {
        $daftarAntrian =
            $this->layanan->antrianVerifikasi();

        return view(
            'pengembalian.antrian',
            compact('daftarAntrian')
        );
    }

    public function formVerifikasi(Peminjaman $peminjaman)
    {
        $peminjaman->load([
            'peminjam',
            'detail.alat'
        ]);

        return view(
            'pengembalian.form',
            compact('peminjaman')
        );
    }

    public function simpanVerifikasi(
        Request $request,
        Peminjaman $peminjaman
    ) {
        $daftarDetailId =
            $peminjaman->detail->pluck('id')->all();

        $data = $request->validate([
            'tgl_kembali' => [
                'required',
                'date'
            ],

            'denda_kerusakan' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'catatan' => [
                'nullable',
                'string',
                'max:500'
            ],

            'kondisi' => [
                'required',
                'array',
                'size:' . count($daftarDetailId)
            ],

            'kondisi.*' => [
                'required',
                'Rule::in' => Rule::in([
                    'baik',
                    'rusak_ringan',
                    'rusak_berat',
                    'hilang'
                ])
            ],
        ], [
            'kondisi.required' =>
                'Kondisi setiap alat wajib diisi.',

            'kondisi.size' =>
                'Kondisi setiap alat wajib diisi.',
        ]);

        $pengembalian =
            $this->layanan->verifikasi(
                $peminjaman,
                Auth::id(),
                $data['kondisi'],
                $data['tgl_kembali'],
                (float) ($data['denda_kerusakan'] ?? 0),
                $data['catatan'] ?? null
            );

        return redirect()
            ->route(
                'pengembalian.rincian',
                $pengembalian
            )
            ->with(
                'sukses',
                'Pengembalian berhasil diverifikasi.'
            );
    }

    public function rincian(
        Pengembalian $pengembalian
    ) {
        $pengembalian->load([
            'peminjaman.detail.alat',
            'peminjaman.peminjam',
            'petugas'
        ]);

        return view(
            'pengembalian.rincian',
            compact('pengembalian')
        );
    }
}
