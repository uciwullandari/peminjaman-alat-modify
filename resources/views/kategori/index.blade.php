@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- HEADER & TOMBOL AKSI --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold mb-1" style="color: #0c4a6e;">Kelola Kategori</h3>
            <p class="text-muted small mb-0">Atur pengelompokan alat dan inventaris dengan lebih rapi.</p>
        </div>
        
        <div class="d-flex align-items-center gap-2 w-100 w-md-auto">
            {{-- FORM PENCARIAN BERSIH --}}
            <form action="{{ route('kategori.index') }}" method="GET" class="d-flex gap-2 flex-grow-1">
                <input type="text" name="cari" class="form-control bg-white rounded-3 shadow-sm" placeholder="Cari kategori..." value="{{ $kataKunci }}" autocomplete="off">
                <button type="submit" class="btn btn-light border fw-medium rounded-3">Cari</button>
                @if($kataKunci)
                    <a href="{{ route('kategori.index') }}" class="btn btn-link text-decoration-none text-muted">Reset</a>
                @endif
            </form>

            <a href="{{ route('kategori.create') }}" class="btn text-white fw-semibold px-3 py-2 rounded-3 shadow-sm text-nowrap" style="background-color: #0284c7;">
                + Tambah Kategori
            </a>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if (session('sukses'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- CARD GRID SYSTEM --}}
    <div class="row g-4">
        @forelse ($daftarKategori as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-card" style="transition: all 0.25s ease-in-out;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        
                        <div>
                            {{-- TOP CARD: ICON & BADGE --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center fw-bold text-primary" style="width: 48px; height: 48px; background-color: #e0f2fe; color: #0284c7 !important;">
                                    {{ strtoupper(substr($item->nama, 0, 2)) }}
                                </div>
                                <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background-color: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd;">
                                    {{ $item->daftar_alat_count ?? 0 }} Alat Tersedia
                                </span>
                            </div>

                            {{-- KONTEN --}}
                            <h5 class="fw-bold mb-2 text-dark">{{ $item->nama }}</h5>
                            <p class="text-muted small mb-4 line-clamp-2" style="min-height: 40px;">
                                {{ $item->deskripsi ?? 'Tidak ada deskripsi untuk kategori ini.' }}
                            </p>
                        </div>

                        {{-- FOOTER: AKSI --}}
                        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                            <span class="text-muted extra-small">ID Kategori: #{{ $item->id }}</span>
                            <div class="d-flex gap-2">
                                <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-sm btn-light text-warning fw-semibold px-3 rounded-2 border">
                                    Edit
                                </a>
                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger fw-semibold px-3 rounded-2 border">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                    <div class="card-body">
                        <p class="text-muted mb-0">Belum ada kategori yang ditambahkan.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

</div>

<style>
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .extra-small {
        font-size: 11px;
    }
</style>
@endsection