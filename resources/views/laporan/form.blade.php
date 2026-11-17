@extends('layouts.utama')

@section('judul', 'Cetak Laporan')

@section('content')

<div class="container py-4 laporan-page">
<div class="mb-4">
    <h3 class="fw-bold mb-1">Cetak Laporan</h3>
    <p class="text-muted mb-0">Pilih jenis laporan dan unduh datanya dalam format Excel.</p>
</div>

<div class="row g-4">

    <div class="col-md-4">
        @include('laporan.form-rpt-01')
    </div>

    <div class="col-md-4">
        @include('laporan.form-rpt-02')
    </div>

    <div class="col-md-4">
        @include('laporan.form-rpt-03')
    </div>

</div>

<style>
    .laporan-page h3 { color: #172033; }
    .laporan-page .laporan-card {
        height: 100%;
        border: 0;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, .07);
        overflow: hidden;
    }
    .laporan-page .laporan-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        color: #172033;
        font-weight: 700;
        padding: 1rem 1.15rem;
    }
    .laporan-page .laporan-card .card-body { padding: 1.25rem 1.15rem; }
    .laporan-page .laporan-card .form-label {
        color: #475569;
        font-weight: 600;
        margin-bottom: .45rem;
    }
    .laporan-page .laporan-card .form-control,
    .laporan-page .laporan-card .form-select {
        min-height: 42px;
        border-color: #dbe3ec;
        border-radius: 8px;
    }
    .laporan-page .laporan-card .form-control:focus,
    .laporan-page .laporan-card .form-select:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .12);
    }
    .laporan-page .laporan-card .btn-cetak {
        border: 0;
        border-radius: 8px;
        padding: .65rem 1rem;
        font-weight: 700;
    }
</style>
</div>

@endsection
