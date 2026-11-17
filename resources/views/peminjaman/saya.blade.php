@extends('layouts.utama')

@section('judul', 'Peminjaman Saya')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="loan-history-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
        <div>
            <span class="text-primary fw-bold small text-uppercase">Riwayat transaksi</span>
            <h2 class="fw-bold mb-1">Peminjaman Saya</h2>
            <p class="text-muted mb-0">Pantau status pengajuan, konfirmasi petugas, dan pengembalian alat kamu.</p>
        </div>
        <a href="{{ route('katalog.daftar') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-lg me-1"></i> Ajukan Peminjaman
        </a>
    </div>

    <div class="history-card">
        <div class="p-3 p-md-4">
            <div class="table-responsive">
            @include('peminjaman.tabel-pinjaman')
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $daftarPeminjaman->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .history-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 0.75rem; box-shadow: 0 0.125rem 0.35rem rgba(15, 23, 42, 0.04); }
    .history-table th { color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.03em; white-space: nowrap; }
    .history-table td, .history-table th { padding: 0.9rem 0.65rem; }
    .history-table tbody tr { border-bottom: 1px solid #f1f5f9; }
    .history-table tbody tr:last-child { border-bottom: 0; }
    .history-actions { min-width: 170px; }
</style>
@endsection