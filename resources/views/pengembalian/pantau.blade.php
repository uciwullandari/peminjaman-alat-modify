@extends('layouts.utama')

@section('judul', 'Pemantauan Peminjaman')

@section('content')

    <div class="container py-4 pemantauan-page">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Pemantauan Peminjaman Berjalan</h3>
            <p class="text-muted mb-0">Pantau status peminjaman alat yang masih berlangsung.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">

            <div class="table-responsive">
                @include('pengembalian.tabel-pantau')
            </div>

                <div class="pagination-wrap px-4 py-3">
                    {{ $daftarPeminjaman->links() }}
                </div>

            </div>
        </div>
    </div>

    <style>
        .pemantauan-page h3 { color: #172033; }
        .pemantauan-page .pagination-wrap nav > div:last-child {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }
        .pemantauan-page .pagination-wrap nav p {
            margin-bottom: 0;
            color: #64748b;
            font-size: 13px;
        }
        .pemantauan-page .pagination {
            gap: 4px;
            margin-bottom: 0;
        }
        .pemantauan-page .page-link { border-radius: 7px; }
        @media (max-width: 768px) {
            .pemantauan-page .pagination-wrap nav > div:last-child {
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>

@endsection