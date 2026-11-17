<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use App\Enums\StatusPeminjaman;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    public function __construct(
        private PeminjamanService $layanan
    ) {
    }

    /**
     * Menampilkan antrian pengajuan peminjaman.
     */
    public function antrian()
    {
        $daftarPengajuan = $this->layanan->antrianPengajuan();

        return view(
            'persetujuan.antrian',
            compact('daftarPengajuan')
        );
    }

    /**
     * Menampilkan rincian pengajuan.
     */
    public function rincian(Peminjaman $peminjaman)
    {
        $peminjaman->load([
            'peminjam',
            'detail.alat',
        ]);

        return view(
            'persetujuan.rincian',
            compact('peminjaman')
        );
    }

    /**
     * Menyetujui pengajuan peminjaman.
     *
     * Setelah disetujui, status berubah menjadi DIPINJAM
     * melalui PeminjamanService.
     */
    public function setujui(
        Request $request,
        Peminjaman $peminjaman
    ) {
        $data = $request->validate([
            'tgl_harus_kembali' => [
                'required',
                'date',
                'after_or_equal:' .
                    $peminjaman->tgl_pinjam->toDateString(),
            ],
        ]);

        try {
            $this->layanan->setujui(
                $peminjaman,
                auth()->id(),
                $data['tgl_harus_kembali']
            );
        } catch (QueryException $e) {
            return back()->with(
                'gagal',
                $this->pesanRamah($e)
            );
        }

        return redirect()
            ->route('persetujuan.antrian')
            ->with(
                'sukses',
                'Peminjaman ' .
                $peminjaman->kode_pinjam .
                ' disetujui.'
            );
    }

    /**
     * Menolak pengajuan peminjaman.
     */
    public function tolak(
        Request $request,
        Peminjaman $peminjaman
    ) {
        $data = $request->validate(
            [
                'alasan_tolak' => [
                    'required',
                    'string',
                    'min:5',
                    'max:500',
                ],
            ],
            [
                'alasan_tolak.required' =>
                    'Alasan penolakan wajib diisi.',
                'alasan_tolak.min' =>
                    'Alasan penolakan minimal 5 karakter.',
            ]
        );

        $this->layanan->tolak(
            $peminjaman,
            auth()->id(),
            $data['alasan_tolak']
        );

        return redirect()
            ->route('persetujuan.antrian')
            ->with(
                'sukses',
                'Peminjaman ' .
                $peminjaman->kode_pinjam .
                ' ditolak.'
            );
    }

    /**
     * Menampilkan peminjaman yang sedang berlangsung
     * pada halaman Pemantauan.
     *
     * Status yang ditampilkan adalah DIPINJAM.
     */
    public function pemantauan()
    {
        $daftarPeminjaman = Peminjaman::with([
            'peminjam',
            'detail.alat',
        ])
            ->where(
                'status',
                StatusPeminjaman::Dipinjam->value
            )
            ->orderByDesc('tgl_pinjam')
            ->paginate(10);

        return view(
            'pemantauan.index',
            compact('daftarPeminjaman')
        );
    }

    /**
     * Menampilkan rincian peminjaman pada Pemantauan.
     */
    public function pemantauanRincian(
        Peminjaman $peminjaman
    ) {
        $peminjaman->load([
            'peminjam',
            'detail.alat',
        ]);

        return view(
            'pemantauan.rincian',
            compact('peminjaman')
        );
    }

    /**
     * Pesan error yang lebih mudah dipahami.
     */
    private function pesanRamah(
        QueryException $e
    ): string {
        $pesanAsli = $e->errorInfo[2] ?? '';

        return $pesanAsli !== ''
            ? $pesanAsli
            : 'Persetujuan gagal diproses. Silakan coba lagi.';
    }
}
