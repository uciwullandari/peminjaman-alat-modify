@extends('layouts.utama')

@section('judul', 'Daftar Pengguna')

@section('content')
<div class="container py-4 pengguna-page">

    {{-- HEADER HALAMAN & TOMBOL TAMBAH --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Daftar Pengguna</h3>
            <p class="text-muted small mb-0">Kelola data pengguna, peran, dan hak akses sistem peminjaman.</p>
        </div>

        <div>
            <a href="{{ route('pengguna.create') }}" class="btn btn-primary px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2 fw-semibold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Pengguna</span>
            </a>
        </div>
    </div>

    {{-- FORM PENCARIAN --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
        @include('pengguna.form-pencarian')
    </div>

    {{-- TABEL DATA PENGGUNA --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        @include('pengguna.table')
    </div>

    {{-- PAGINATION --}}
    <div class="custom-pagination-wrapper d-flex justify-content-end align-items-center mt-3">
        {{ $daftarPengguna->links() }}
    </div>

</div>

<style>
    .pengguna-page .custom-pagination-wrapper nav > div:last-child {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 12px !important;
    }

    .pengguna-page .custom-pagination-wrapper nav p {
        margin-bottom: 0 !important;
        color: #64748b !important;
        font-size: 13px !important;
    }

    .pengguna-page .custom-pagination-wrapper .pagination {
        gap: 4px !important;
        margin-bottom: 0 !important;
    }

    .pengguna-page .custom-pagination-wrapper .page-link {
        border-radius: 7px;
    }

    @media (max-width: 768px) {
        .pengguna-page .custom-pagination-wrapper nav > div:last-child {
            justify-content: center !important;
            flex-wrap: wrap;
        }
    }
</style>
@endsection