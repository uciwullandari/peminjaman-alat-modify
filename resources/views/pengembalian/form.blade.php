@extends('layouts.utama')
@section('judul', 'Verifikasi Pengembalian')
@section('content')
    <div class="container py-4 verifikasi-form-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Verifikasi Pengembalian</h3>
            <p class="text-muted mb-0">{{ $peminjaman->kode_pinjam }} · Periksa kondisi alat dan data pengembalian.</p>
        </div>

        <a href="{{ route('pengembalian.antrian') }}"
           class="btn btn-light border rounded-3 px-3 fw-semibold text-secondary">
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('pengembalian.simpan', $peminjaman) }}">
        @csrf

        <div class="row g-4">
            <div class="col-md-8 mb-3">
                @include('pengembalian.kondisi-alat')

                <div class="alert alert-info mt-3 mb-0 small">
                    Alat berkondisi <strong>baik</strong> dan <strong>rusak ringan</strong>
                    kembali menambah stok tersedia. Alat berkondisi
                    <strong>rusak berat</strong> dan <strong>hilang</strong>
                    mengurangi stok total.
                </div>
            </div>

            <div class="col-md-4">
                @include('pengembalian.data-pengembalian')
            </div>
        </div>

    </form>
    </div>

    <style>
        .verifikasi-form-page h3 { color: #172033; }
        .verifikasi-form-page .card {
            border: 0; border-radius: 14px; box-shadow: 0 4px 14px rgba(15, 23, 42, .07); overflow: hidden;
        }
        .verifikasi-form-page .card-header {
            background: #fff; border-bottom: 1px solid #e2e8f0; font-weight: 700; padding: 1rem 1.15rem;
        }
        .verifikasi-form-page .form-control, .verifikasi-form-page .form-select {
            border-color: #dbe3ec; border-radius: 8px;
        }
        .verifikasi-form-page .form-control:focus, .verifikasi-form-page .form-select:focus {
            border-color: #60a5fa; box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .12);
        }
    </style>
@endsection