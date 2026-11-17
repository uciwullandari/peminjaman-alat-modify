@extends('layouts.utama')
@section('judul', 'Antrian Verifikasi Pengembalian')
@section('content')
    <div class="container py-4 verifikasi-page">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Antrian Verifikasi Pengembalian</h3>
            <p class="text-muted mb-0">Periksa kondisi alat sebelum pengembalian diselesaikan.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
            <div class="table-responsive">
                @include('pengembalian.tabel-antrian')
            </div>

                <div class="pagination-wrap px-4 py-3">
                    {{ $daftarAntrian->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .verifikasi-page h3 { color: #172033; }
        .verifikasi-page .pagination-wrap nav > div:last-child {
            display: flex; align-items: center; justify-content: flex-end; gap: 12px;
        }
        .verifikasi-page .pagination-wrap nav p { margin-bottom: 0; color: #64748b; font-size: 13px; }
        .verifikasi-page .pagination { gap: 4px; margin-bottom: 0; }
        .verifikasi-page .page-link { border-radius: 7px; }
    </style>
@endsection