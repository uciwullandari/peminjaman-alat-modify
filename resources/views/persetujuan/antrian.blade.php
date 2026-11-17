@extends('layouts.utama')

@section('judul', 'Antrean Pengajuan')

@section('content')

<div class="container py-4 persetujuan-page">
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Konfirmasi Peminjaman</h3>
        <p class="text-muted mb-0">Periksa dan konfirmasi pengajuan peminjaman dari peminjam sebelum alat diserahkan.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
        <div class="table-responsive">

            @include('persetujuan.tabel-antrian')

        </div>

        </div>

        <div class="pagination-wrap px-4 py-3">
            {{ $daftarPengajuan->links() }}
        </div>

    </div>
    </div>
</div>

<style>
    .persetujuan-page h3 {
        color: #172033;
    }

    .persetujuan-page .pagination-wrap nav > div:last-child {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }

    .persetujuan-page .pagination-wrap nav p {
        margin-bottom: 0;
        color: #64748b;
        font-size: 13px;
    }

    .persetujuan-page .pagination {
        gap: 4px;
        margin-bottom: 0;
    }

    .persetujuan-page .page-link {
        border-radius: 7px;
    }

    @media (max-width: 768px) {
        .persetujuan-page .pagination-wrap nav > div:last-child {
            justify-content: center;
            flex-wrap: wrap;
        }
    }
</style>

@endsection