@extends('layouts.utama')

@section('judul', 'Daftar Alat')

@section('content')
<div class="container-fluid py-2">

    {{-- HEADER HALAMAN & TOMBOL TAMBAH (SEJAJAR SEPERTI KATEGORI) --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Daftar Inventaris Alat</h3>
            <p class="text-muted small mb-0">Kelola ketersediaan, kondisi, dan data seluruh alat peminjaman.</p>
        </div>
        
        <div>
            <a href="{{ route('alat.create') }}" class="btn btn-primary px-3 py-2 rounded-3 fw-semibold shadow-sm text-white text-decoration-none d-inline-flex align-items-center gap-2">
                <span class="fs-5 lh-1 fw-bold">+</span>
                <span>Tambah Alat</span>
            </a>
        </div>
    </div>

    {{-- FILTER & PENCARIAN (FORM BAWAAN TIDAK DIUSIK LAGO) --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
        @include('alat.form-pencarian')
    </div>

    {{-- TABEL DATA --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase fs-7" style="width: 80px;">Foto</th>
                        <th class="py-3 text-secondary text-uppercase fs-7">Info Alat</th>
                        <th class="py-3 text-secondary text-uppercase fs-7">Kategori</th>
                        <th class="py-3 text-secondary text-uppercase fs-7 text-center">Stok / Tersedia</th>
                        <th class="py-3 text-secondary text-uppercase fs-7 text-center">Kondisi</th>
                        <th class="pe-4 py-3 text-secondary text-uppercase fs-7 text-center" style="width: 170px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($daftarAlat as $alat)
                        <tr>
                            <td class="ps-4 py-3">
                                @if ($alat->foto)
                                    <img
                                        src="{{ asset('gambar/alat/' . $alat->foto) }}"
                                        alt="{{ $alat->nama }}"
                                        class="rounded-3 shadow-sm object-fit-cover"
                                        width="48"
                                        height="48"
                                    >
                                @else
                                    <div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 48px; height: 48px;">
                                        🛠️
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div class="fw-bold text-dark mb-0">{{ $alat->nama }}</div>
                                <span class="badge bg-light text-secondary border fw-medium" style="font-size: 11px;">
                                    {{ $alat->kode_alat }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-info-subtle text-info-emphasis px-2.5 py-1.5 rounded-pill fw-semibold">
                                    {{ $alat->kategori->nama ?? 'Tanpa Kategori' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="fw-semibold text-dark">{{ $alat->stok }}</span> / 
                                <span class="badge bg-{{ $alat->stok_tersedia > 0 ? 'success' : 'secondary' }} px-2 py-1 rounded-pill fw-bold">
                                    {{ $alat->stok_tersedia }} Tersedia
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-medium text-capitalize">
                                    ● {{ str_replace('_', ' ', $alat->kondisi) }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="pe-4 text-center">
                                <div class="d-inline-flex gap-2 justify-content-center align-items-center">
                                    <a href="{{ route('alat.edit', $alat) }}" 
                                       class="btn-action btn-edit text-decoration-none" 
                                       title="Edit Alat">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('alat.destroy', $alat) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data alat {{ $alat->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Hapus Alat">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Data alat tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION CONTAINER --}}
    <div class="custom-pagination-wrapper d-flex justify-content-end align-items-center mt-3">
        {{ $daftarAlat->links() }}
    </div>

</div>

<style>
    .fs-7 { font-size: 12px; letter-spacing: 0.5px; }
    .table > :not(caption) > * > * { padding: 0.85rem 0.75rem; }

    /* TOMBOL AKSI TERANG & KONTRAS */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 20px;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .btn-edit {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }
    .btn-edit:hover {
        background-color: #fde047;
        color: #713f12;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(234, 179, 8, 0.25);
    }

    .btn-delete {
        background-color: #ffe4e6;
        color: #9f1239;
        border: 1px solid #fecdd3;
    }
    .btn-delete:hover {
        background-color: #f87171;
        color: #ffffff;
        border-color: #f87171;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(248, 113, 113, 0.3);
    }

    /* STYLING PAGINATION BANGET */
    .custom-pagination-wrapper nav > div:first-child {
        display: none !important;
    }
    
    .custom-pagination-wrapper nav > div:last-child {
        display: flex !important;
        align-items: center !important;
        gap: 15px !important;
    }

    .custom-pagination-wrapper nav ul.pagination {
        margin-left: 0 !important;
        gap: 4px !important;
    }

    .custom-pagination-wrapper nav p {
        margin-bottom: 0 !important;
        font-size: 13px !important;
        color: #6c757d !important;
    }

    .custom-pagination-wrapper span.relative,
    .custom-pagination-wrapper a.relative {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 34px !important;
        height: 34px !important;
        padding: 0 10px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        border-radius: 8px !important;
        border: 1px solid #dee2e6 !important;
        color: #495057 !important;
        background-color: #fff !important;
        text-decoration: none !important;
        box-shadow: none !important;
        line-height: 1 !important;
    }

    .custom-pagination-wrapper svg {
        width: 14px !important;
        height: 14px !important;
        vertical-align: middle !important;
    }

    .custom-pagination-wrapper span[aria-current="page"] span {
        background-color: #0d6efd !important;
        color: #fff !important;
        border-color: #0d6efd !important;
        border-radius: 8px !important;
    }

    .custom-pagination-wrapper a.relative:hover {
        background-color: #e9ecef !important;
        color: #0d6efd !important;
    }
</style>
@endsection