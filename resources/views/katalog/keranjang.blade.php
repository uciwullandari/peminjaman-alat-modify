@extends('layouts.utama')

@section('judul', 'Keranjang Peminjaman')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="cart-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
        <div>
            <span class="text-primary fw-bold small text-uppercase">Persiapan peminjaman</span>
            <h2 class="fw-bold mb-1">Keranjang Peminjaman</h2>
            <p class="text-muted mb-0">Periksa alat dan jumlahnya sebelum melanjutkan pengajuan.</p>
        </div>

        <a href="{{ route('katalog.daftar') }}" class="btn btn-outline-primary rounded-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
        </a>
    </div>

    @if ($isiKeranjang->isEmpty())
        <div class="cart-empty text-center py-5 px-3">
            <div class="empty-icon mx-auto mb-3"><i class="bi bi-cart3"></i></div>
            <h5 class="fw-bold mb-2">Keranjang masih kosong</h5>
            <p class="text-muted mb-4">Pilih alat dari katalog untuk mulai membuat pengajuan.</p>
            <a href="{{ route('katalog.daftar') }}" class="btn btn-primary rounded-3">
                <i class="bi bi-grid me-1"></i> Buka Katalog
            </a>
        </div>
    @else
        <div class="cart-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 px-3 px-md-4 py-3 border-bottom">
                <div class="fw-bold"><i class="bi bi-bag-check text-primary me-2"></i>{{ $isiKeranjang->count() }} jenis alat dipilih</div>
                <span class="text-muted small">Atur jumlah sebelum mengajukan</span>
            </div>
            <div class="p-3 p-md-4">
                <div class="table-responsive">
                    @include('katalog.tabel-keranjang')
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                    <form method="POST" action="{{ route('katalog.kosongkan') }}"
                        onsubmit="return confirm('Kosongkan seluruh keranjang?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger rounded-3">
                            <i class="bi bi-trash3 me-1"></i> Kosongkan
                        </button>
                    </form>

                    <a href="{{ route('peminjaman.ajukan') }}" class="btn btn-success rounded-3 px-4">
                        Lanjut ke Pengajuan <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .cart-card, .cart-empty { background: #fff; border: 1px solid #e2e8f0; border-radius: 0.75rem; box-shadow: 0 0.125rem 0.35rem rgba(15, 23, 42, 0.04); }
    .cart-empty { border-style: dashed; }
    .empty-icon { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #e0f2fe; color: #0284c7; font-size: 1.75rem; }
</style>
@endsection