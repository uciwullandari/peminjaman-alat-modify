<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengaturan;
use App\Services\ExcelReportService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct(private ExcelReportService $excel)
    {
    }

    public function form()
    {
        $daftarKategori = Kategori::orderBy('nama')->get();

        return view('laporan.form', compact('daftarKategori'));
    }

    public function peminjaman(Request $request)
    {
        $data = $request->validate([
            'tgl_awal' => ['required', 'date'],
            'tgl_akhir' => ['required', 'date', 'after_or_equal:tgl_awal'],
            'status' => ['nullable', 'string'],
        ]);

        $daftarPeminjaman = Peminjaman::with([
            'peminjam',
            'detail.alat'
        ])
            ->whereBetween('tgl_pinjam', [
                $data['tgl_awal'],
                $data['tgl_akhir']
            ])
            ->when(
                $data['status'] ?? null,
                function ($query, $status) {
                    return $query->where('status', $status);
                }
            )
            ->orderBy('tgl_pinjam')
            ->get();

        $rows = [['No', 'Kode Pinjam', 'Peminjam', 'Tanggal Pinjam', 'Harus Kembali', 'Alat', 'Status']];

        foreach ($daftarPeminjaman as $nomor => $peminjaman) {
            $rows[] = [
                $nomor + 1,
                $peminjaman->kode_pinjam,
                $peminjaman->peminjam?->nama,
                $peminjaman->tgl_pinjam->format('d/m/Y'),
                $peminjaman->tgl_harus_kembali->format('d/m/Y'),
                $peminjaman->detail->map(fn ($detail) => $detail->alat->nama . ' (' . $detail->jumlah . ')')->implode(', '),
                $peminjaman->status->label(),
            ];
        }

        return $this->excel->download('laporan-peminjaman.xlsx', $rows);
    }

    public function pengembalian(Request $request)
    {
        $data = $request->validate([
            'tgl_awal' => ['required', 'date'],
            'tgl_akhir' => ['required', 'date', 'after_or_equal:tgl_awal'],
        ]);

        $daftarPengembalian = Pengembalian::with([
            'peminjaman.peminjam',
            'peminjaman.detail.alat',
            'petugas'
        ])
            ->whereBetween('tgl_kembali', [
                $data['tgl_awal'],
                $data['tgl_akhir']
            ])
            ->orderBy('tgl_kembali')
            ->get();

        $rows = [['No', 'Kode Pinjam', 'Peminjam', 'Tanggal Kembali', 'Terlambat (Hari)', 'Denda Telat', 'Denda Rusak', 'Total Denda', 'Petugas']];

        foreach ($daftarPengembalian as $nomor => $pengembalian) {
            $rows[] = [
                $nomor + 1,
                $pengembalian->peminjaman?->kode_pinjam,
                $pengembalian->peminjaman?->peminjam?->nama,
                $pengembalian->tgl_kembali->format('d/m/Y'),
                $pengembalian->hari_terlambat,
                $pengembalian->denda,
                $pengembalian->denda_kerusakan,
                $pengembalian->total_denda,
                $pengembalian->petugas?->nama,
            ];
        }

        return $this->excel->download('laporan-pengembalian.xlsx', $rows);
    }

    public function stok(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => ['nullable', 'exists:kategori,id'],
        ]);

        $daftarAlat = Alat::with('kategori')
            ->when(
                $data['kategori_id'] ?? null,
                function ($query, $kategoriId) {
                    return $query->where('kategori_id', $kategoriId);
                }
            )
            ->orderBy('kode_alat')
            ->get();

        $rows = [['No', 'Kode Alat', 'Nama Alat', 'Kategori', 'Stok', 'Tersedia', 'Dipinjam', 'Kondisi']];

        foreach ($daftarAlat as $nomor => $alat) {
            $rows[] = [
                $nomor + 1,
                $alat->kode_alat,
                $alat->nama,
                $alat->kategori?->nama,
                $alat->stok,
                $alat->stok_tersedia,
                $alat->stok - $alat->stok_tersedia,
                str_replace('_', ' ', $alat->kondisi),
            ];
        }

        return $this->excel->download('laporan-stok-alat.xlsx', $rows);
    }
}
