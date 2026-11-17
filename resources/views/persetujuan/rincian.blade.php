@extends('layouts.utama')

@section('judul', 'Proses Pengajuan')

@section('content')

<div class="container py-4 persetujuan-detail-page">
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">Proses Pengajuan</h3>
        <p class="text-muted mb-0">{{ $peminjaman->kode_pinjam }} · Tinjau data sebelum mengambil keputusan.</p>
    </div>

    <a href="{{ route('persetujuan.antrian') }}"
    class="btn btn-light border rounded-3 px-3 fw-semibold text-secondary">
        Kembali
    </a>
</div>

<div class="row g-4">

    <div class="col-md-7 mb-3">
        @include('persetujuan.alat-diajukan')
    </div>

    <div class="col-md-5">
        @include('persetujuan.form-setujui')
    </div>

</div>

<style>
    .persetujuan-detail-page h3 { color: #172033; }
    .persetujuan-detail-page .card {
        border: 0;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, .07);
        overflow: hidden;
    }
    .persetujuan-detail-page .card-header {
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 700;
        padding: 1rem 1.15rem;
    }
</style>
</div>

@endsection