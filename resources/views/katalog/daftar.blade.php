@extends('layouts.utama')

@section('judul', 'Katalog Alat')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="catalog-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
        <div>
            <span class="text-primary fw-bold small text-uppercase">Inventaris alat</span>
            <h2 class="fw-bold mb-1">Katalog Alat</h2>
            <p class="text-muted mb-0">Pilih alat yang kamu perlukan untuk dimasukkan ke keranjang.</p>
        </div>
        <a href="{{ route('katalog.keranjang') }}" class="btn btn-outline-primary rounded-3">
            <i class="bi bi-cart3 me-1"></i> Lihat Keranjang
        </a>
    </div>

    @include('katalog.form-pencarian')

    <div class="row g-4">
        @forelse ($daftarAlat as $alat)
            <div class="col-md-6 col-lg-4">
                <div class="card catalog-card h-100 border-0 shadow-sm">

                    @if ($alat->foto)
                        <img src="{{ asset('gambar/alat/' . $alat->foto) }}"
                            class="card-img-top catalog-image"
                            alt="{{ $alat->nama }}">
                    @else
                        <div class="catalog-image bg-light d-flex flex-column align-items-center justify-content-center">
                            <i class="bi bi-image text-secondary opacity-50" style="font-size: 2rem;"></i>
                            <span class="text-muted small mt-1">Foto belum tersedia</span>
                        </div>
                    @endif

                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title fs-6 fw-bold mb-1">
                                {{ $alat->nama }}
                            </h5>

                            <span class="badge rounded-pill bg-{{ $alat->stok_tersedia > 0 ? 'success' : 'secondary' }} ms-2">
                                {{ $alat->stok_tersedia }} tersedia
                            </span>
                        </div>

                        <p class="text-muted small mb-3">
                            {{ $alat->kode_alat }} &middot; {{ $alat->kategori->nama }}
                        </p>

                        @if ($alat->stok_tersedia > 0)

                            <form method="POST"
                                action="{{ route('katalog.tambah', $alat) }}"
                                class="row g-2 align-items-center">

                                @csrf

                                <div class="col-4">
                                    <input
                                        type="number"
                                        name="jumlah"
                                        class="form-control form-control-sm catalog-quantity"
                                        value="1"
                                        min="1"
                                        max="{{ $alat->stok_tersedia }}"
                                        required
                                        oninvalid="this.setCustomValidity('Jumlah tidak boleh melebihi stok tersedia.')"
                                        oninput="this.setCustomValidity('')">
                                </div>

                                <div class="col-8">
                                    <button type="submit"
                                        class="btn btn-sm btn-primary w-100">
                                        <i class="bi bi-cart-plus me-1"></i> Tambah
                                    </button>
                                </div>

                            </form>

                        @else

                            <button class="btn btn-sm btn-secondary w-100" disabled>
                                <i class="bi bi-x-circle me-1"></i>
                                Stok Habis
                            </button>

                        @endif
                    </div>
                </div>
            </div>

        @empty

            <div class="col-12">
                <div class="empty-catalog text-center py-5">
                    <i class="bi bi-search text-muted" style="font-size: 2rem;"></i>
                    <p class="text-muted mb-0 mt-2">Alat tidak ditemukan.</p>
                </div>
            </div>

        @endforelse
    </div>

    <div class="catalog-pagination mt-4 d-flex justify-content-end">
        {{ $daftarAlat->links() }}
    </div>
</div>

<style>
    .catalog-filter {
        padding: 1rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.35rem rgba(15, 23, 42, 0.04);
    }
    .catalog-card {
        overflow: hidden;
        border-radius: 0.75rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .catalog-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.75rem 1.5rem rgba(15, 23, 42, 0.1) !important;
    }
    .catalog-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .catalog-quantity {
        min-width: 0;
    }
    .empty-catalog {
        border: 1px dashed #cbd5e1;
        border-radius: 0.75rem;
        background: #ffffff;
    }
    .catalog-pagination nav {
        margin-left: auto;
    }
    @media (max-width: 575.98px) {
        .catalog-pagination {
            justify-content: center !important;
        }
    }
</style>
@endsection