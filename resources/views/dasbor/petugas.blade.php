@extends('layouts.utama')

@section('judul', 'Dasbor Petugas')

@section('content')
<!-- Import Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="py-2">

    {{-- BANNER WELCOME --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-md-9">
                <span class="badge bg-white bg-opacity-20 text-white px-3 py-1.5 rounded-pill fw-semibold mb-2" style="font-size: 11px;">DASBOR PETUGAS</span>
                <h3 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->nama ?? 'Petugas Laboratorium' }} 👋</h3>
                <p class="text-white-50 mb-0 small">Pantau dan kelola seluruh pengajuan, peminjaman, serta pengembalian alat hari ini.</p>
            </div>
            <div class="col-md-3 text-end d-none d-md-block">
                <i class="bi bi-clipboard-data text-white opacity-25" style="font-size: 4rem;"></i>
            </div>
        </div>
    </div>

    {{-- CARD STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 d-flex align-items-center justify-content-center text-warning" style="background-color: #fef3c7; width: 50px; height: 50px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">PERLU PERSETUJUAN</small>
                        <span class="fw-bold fs-4 text-dark">{{ $totalPersetujuan ?? 0 }}</span>
                        <small class="text-muted d-block" style="font-size: 11px;">Pengajuan Baru</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 d-flex align-items-center justify-content-center text-primary" style="background-color: #e0f2fe; width: 50px; height: 50px;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">SEDANG DIPINJAM</small>
                        <span class="fw-bold fs-4 text-dark">{{ $totalDipinjam ?? 0 }}</span>
                        <small class="text-muted d-block" style="font-size: 11px;">Alat di Luar</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 d-flex align-items-center justify-content-center text-success" style="background-color: #dcfce7; width: 50px; height: 50px;">
                        <i class="bi bi-arrow-return-left fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">PENGEMBALIAN</small>
                        <span class="fw-bold fs-4 text-dark">{{ $totalPengembalian ?? 0 }}</span>
                        <small class="text-muted d-block" style="font-size: 11px;">Perlu Verifikasi</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 d-flex align-items-center justify-content-center text-danger" style="background-color: #ffe4e6; width: 50px; height: 50px;">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">TERLAMBAT</small>
                        <span class="fw-bold fs-4 text-dark">{{ $totalTerlambat ?? 0 }}</span>
                        <small class="text-muted d-block" style="font-size: 11px;">Belum Kembali</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 p-4 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-1">Registrasi Peminjaman Menunggu Konfirmasi</h5>
                <p class="text-muted small mb-0">Daftar peminjam yang sudah mengajukan peminjaman alat.</p>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background-color: #fef3c7; color: #b45309;">
                {{ $totalPersetujuan }} menunggu
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small">Kode Pinjam</th>
                        <th class="py-3 text-secondary small">Nama Peminjam</th>
                        <th class="py-3 text-secondary small">Tanggal Pinjam</th>
                        <th class="py-3 text-secondary small text-center">Jumlah Alat</th>
                        <th class="pe-4 py-3 text-secondary small text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registrasiPeminjamanMenunggu as $peminjaman)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $peminjaman->kode_pinjam }}</td>
                            <td>{{ $peminjaman->peminjam?->nama ?? '-' }}</td>
                            <td class="text-muted">{{ $peminjaman->tgl_pinjam->format('d/m/Y') }}</td>
                            <td class="text-center">{{ $peminjaman->detail->sum('jumlah') }}</td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('persetujuan.rincian', $peminjaman) }}" class="btn btn-sm btn-outline-primary rounded-3">Proses</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada registrasi peminjaman yang menunggu konfirmasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="d-flex justify-content-between align-items-center gap-2 p-4 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-1">Notifikasi Keterlambatan</h5>
                <p class="text-muted small mb-0">Peminjaman yang melewati batas pengembalian.</p>
            </div>
            <span class="badge rounded-pill px-3 py-2 bg-danger-subtle text-danger">{{ $peminjamanTerlambat->count() }} terlambat</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light"><tr><th class="ps-4 py-3 text-secondary small">Peminjam</th><th class="py-3 text-secondary small">Kode</th><th class="py-3 text-secondary small">Terlambat</th><th class="pe-4 py-3 text-secondary small text-end">Denda</th></tr></thead>
                <tbody>
                    @forelse ($peminjamanTerlambat as $peminjaman)
                        <tr><td class="ps-4 fw-semibold">{{ $peminjaman->peminjam?->nama ?? '-' }}</td><td>{{ $peminjaman->kode_pinjam }}</td><td><span class="badge bg-danger-subtle text-danger">{{ $peminjaman->hari_terlambat }} hari</span></td><td class="pe-4 text-end fw-semibold text-danger">Rp {{ number_format($peminjaman->denda_keterlambatan_saat_ini, 0, ',', '.') }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada pengembalian yang terlambat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MENU PINTAS --}}
    <h5 class="fw-bold text-dark mb-3">Akses Cepat Tugas</h5>
    <div class="row g-3">
        
        {{-- 1. PERSETUJUAN --}}
        <div class="col-md-4">
            <a href="/persetujuan" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none hover-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-2.5 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-check2-square fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Persetujuan</h6>
                            <small class="text-muted" style="font-size: 11px;">Setujui/tolak pengajuan pinjam</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>
            </a>
        </div>

        {{-- 2. PEMANTAUAN --}}
        <div class="col-md-4">
            <a href="/pemantauan" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none hover-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-info bg-opacity-10 text-info p-2.5 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-eye fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Pemantauan</h6>
                            <small class="text-muted" style="font-size: 11px;">Cek status peminjaman aktif</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>
            </a>
        </div>

        {{-- 3. PENGEMBALIAN --}}
        <div class="col-md-4">
            <a href="/pengembalian" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none hover-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-success bg-opacity-10 text-success p-2.5 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-box-arrow-in-down fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Pengembalian</h6>
                            <small class="text-muted" style="font-size: 11px;">Proses alat yang dikembalikan</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>
            </a>
        </div>

    </div>

</div>

<style>
    .hover-card { transition: all 0.2s ease; }
    .hover-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
</style>
@endsection