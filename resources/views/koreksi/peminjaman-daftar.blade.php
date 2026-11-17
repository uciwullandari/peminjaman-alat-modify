@extends('layouts.utama')

@section('judul', 'Koreksi Data Peminjaman')

@section('content')
    <div class="container py-4 koreksi-page">
        <div class="page-heading mb-4">
            <div>
                <h3 class="fw-bold mb-1">Koreksi Data Peminjaman</h3>
                <p class="text-muted mb-0">Periksa dan ubah data peminjaman yang diajukan.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    @include('koreksi.tabel-peminjaman')
                </div>

                <div class="pagination-wrap px-4 py-3">
                    {{ $daftarPeminjaman->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .koreksi-page .page-heading h3 {
            color: #172033;
        }

        .koreksi-page .pagination-wrap nav > div:last-child {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        .koreksi-page .pagination-wrap nav p {
            margin-bottom: 0;
            color: #64748b;
            font-size: 13px;
        }

        .koreksi-page .pagination-wrap .pagination {
            gap: 4px;
            margin-bottom: 0;
        }

        .koreksi-page .pagination-wrap .page-link {
            border-radius: 7px;
        }

        @media (max-width: 768px) {
            .koreksi-page .pagination-wrap nav > div:last-child {
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>
@endsection
