@extends('layouts.utama')

@section('judul', 'Dasbor Peminjam')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="py-2">
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-md-9">
                <span class="badge bg-white bg-opacity-20 text-white px-3 py-1 rounded-pill fw-semibold mb-2" style="font-size: 11px;">DASBOR PEMINJAM</span>
                <h3 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->nama ?? 'Peminjam' }}!</h3>
                <p class="text-white-50 mb-0 small">Ajukan peminjaman alat, pantau status, dan kelola riwayat peminjaman kamu.</p>
            </div>
            <div class="col-md-3 text-end d-none d-md-block">
                <i class="bi bi-person-workspace text-white opacity-25" style="font-size: 4rem;"></i>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3"><div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100"><div class="d-flex align-items-center gap-3"><div class="rounded-3 p-3 d-flex align-items-center justify-content-center text-warning" style="background-color: #fef3c7; width: 50px; height: 50px;"><i class="bi bi-hourglass-split fs-4"></i></div><div><small class="text-muted d-block fw-bold" style="font-size: 10px;">MENUNGGU PERSETUJUAN</small><span class="fw-bold fs-4 text-dark">{{ $totalPengajuan }}</span><small class="text-muted d-block" style="font-size: 11px;">Pengajuan aktif</small></div></div></div></div>
        <div class="col-12 col-sm-6 col-xl-3"><div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100"><div class="d-flex align-items-center gap-3"><div class="rounded-3 p-3 d-flex align-items-center justify-content-center text-primary" style="background-color: #e0f2fe; width: 50px; height: 50px;"><i class="bi bi-box-seam fs-4"></i></div><div><small class="text-muted d-block fw-bold" style="font-size: 10px;">SEDANG DIPINJAM</small><span class="fw-bold fs-4 text-dark">{{ $totalDipinjam }}</span><small class="text-muted d-block" style="font-size: 11px;">Peminjaman berjalan</small></div></div></div></div>
        <div class="col-12 col-sm-6 col-xl-3"><div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100"><div class="d-flex align-items-center gap-3"><div class="rounded-3 p-3 d-flex align-items-center justify-content-center text-info" style="background-color: #cffafe; width: 50px; height: 50px;"><i class="bi bi-arrow-return-left fs-4"></i></div><div><small class="text-muted d-block fw-bold" style="font-size: 10px;">MENUNGGU PENGEMBALIAN</small><span class="fw-bold fs-4 text-dark">{{ $totalMenungguPengembalian }}</span><small class="text-muted d-block" style="font-size: 11px;">Sedang diverifikasi</small></div></div></div></div>
        <div class="col-12 col-sm-6 col-xl-3"><div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100"><div class="d-flex align-items-center gap-3"><div class="rounded-3 p-3 d-flex align-items-center justify-content-center text-success" style="background-color: #dcfce7; width: 50px; height: 50px;"><i class="bi bi-check2-circle fs-4"></i></div><div><small class="text-muted d-block fw-bold" style="font-size: 10px;">SELESAI</small><span class="fw-bold fs-4 text-dark">{{ $totalSelesai }}</span><small class="text-muted d-block" style="font-size: 11px;">Riwayat selesai</small></div></div></div></div>
    </div>

    <h5 class="fw-bold text-dark mb-3">Akses Cepat</h5>
    <div class="row g-3">
        <div class="col-md-3 col-sm-6"><a href="{{ route('katalog.daftar') }}" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none hover-card h-100"><div class="d-flex align-items-center gap-3"><div class="rounded-3 bg-primary bg-opacity-10 text-primary p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;"><i class="bi bi-grid fs-5"></i></div><div><h6 class="fw-bold text-dark mb-0">Katalog Alat</h6><small class="text-muted">Cari alat yang tersedia</small></div></div></a></div>
        <div class="col-md-3 col-sm-6"><a href="{{ route('katalog.keranjang') }}" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none hover-card h-100"><div class="d-flex align-items-center gap-3"><div class="rounded-3 bg-warning bg-opacity-10 text-warning p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;"><i class="bi bi-cart3 fs-5"></i></div><div><h6 class="fw-bold text-dark mb-0">Keranjang</h6><small class="text-muted">Siapkan pengajuan</small></div></div></a></div>
        <div class="col-md-3 col-sm-6"><a href="{{ route('peminjaman.ajukan') }}" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none hover-card h-100"><div class="d-flex align-items-center gap-3"><div class="rounded-3 bg-success bg-opacity-10 text-success p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;"><i class="bi bi-send fs-5"></i></div><div><h6 class="fw-bold text-dark mb-0">Ajukan Pinjaman</h6><small class="text-muted">Kirim pengajuan alat</small></div></div></a></div>
        <div class="col-md-3 col-sm-6"><a href="{{ route('peminjaman.saya') }}" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none hover-card h-100"><div class="d-flex align-items-center gap-3"><div class="rounded-3 bg-info bg-opacity-10 text-info p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;"><i class="bi bi-clock-history fs-5"></i></div><div><h6 class="fw-bold text-dark mb-0">Peminjaman Saya</h6><small class="text-muted">Lihat status peminjaman</small></div></div></a></div>
    </div>
</div>

<style>
    .hover-card { transition: all 0.2s ease; }
    .hover-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important; }
</style>
@endsection