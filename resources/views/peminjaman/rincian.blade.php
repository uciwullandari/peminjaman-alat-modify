@extends('layouts.utama')

@section('judul', 'Rincian Peminjaman')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="loan-detail-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
        <div>
            <span class="text-primary fw-bold small text-uppercase">Detail transaksi</span>
            <h2 class="fw-bold mb-1">{{ $peminjaman->kode_pinjam }}</h2>
            <p class="text-muted mb-0">Informasi lengkap peminjaman alat.</p>
        </div>

        <a href="{{ route('peminjaman.saya') }}" class="btn btn-outline-primary rounded-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="detail-card mb-4">
        <div class="p-3 p-md-4">
            <div class="d-flex align-items-center gap-2 mb-3 fw-bold">
                <i class="bi bi-clipboard2-check text-primary"></i> Ringkasan Peminjaman
            </div>
            <dl class="row detail-list mb-0">

                <dt class="col-sm-3">
                    Status
                </dt>

                <dd class="col-sm-9">
                    <span class="badge rounded-pill bg-{{ $peminjaman->status->warna() }}">
                        {{ $peminjaman->status->label() }}
                    </span>
                </dd>

                <dt class="col-sm-3">
                    Tanggal Pinjam
                </dt>

                <dd class="col-sm-9">
                    {{ $peminjaman->tgl_pinjam->format('d/m/Y') }}
                </dd>

                <dt class="col-sm-3">
                    Harus Kembali
                </dt>

                <dd class="col-sm-9">
                    {{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}
                </dd>

                <dt class="col-sm-3">
                    Keperluan
                </dt>

                <dd class="col-sm-9">
                    {{ $peminjaman->keperluan ?: '-' }}
                </dd>

                <dt class="col-sm-3">
                    Petugas
                </dt>

                <dd class="col-sm-9">
                    {{ $peminjaman->petugas->nama ?? 'Belum diproses' }}
                </dd>

                @if ($peminjaman->alasan_tolak)
                    <dt class="col-sm-3">
                        Alasan Ditolak
                    </dt>

                    <dd class="col-sm-9 text-danger">
                        <span class="d-inline-block bg-danger-subtle rounded-3 px-3 py-2">
                        {{ $peminjaman->alasan_tolak }}
                        </span>
                    </dd>
                @endif

            </dl>
        </div>
    </div>

    <div class="detail-card overflow-hidden">
        <div class="px-3 px-md-4 py-3 border-bottom fw-bold">
            <i class="bi bi-box-seam text-primary me-2"></i>Daftar Alat
        </div>

        <div class="table-responsive">
            <table class="table detail-table mb-0">

                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Alat</th>
                        <th class="text-center">
                            Jumlah
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($peminjaman->detail as $baris)
                        <tr>
                            <td class="text-muted small fw-semibold">
                                {{ $baris->alat->kode_alat }}
                            </td>

                            <td class="fw-semibold">
                                {{ $baris->alat->nama }}
                            </td>

                            <td class="text-center">
                                <span class="badge rounded-pill bg-primary-subtle text-primary">{{ $baris->jumlah }} unit</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<style>
    .detail-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 0.75rem; box-shadow: 0 0.125rem 0.35rem rgba(15, 23, 42, 0.04); }
    .detail-list dt, .detail-list dd { padding: 0.55rem 0; margin-bottom: 0; border-bottom: 1px solid #f1f5f9; }
    .detail-list dt { color: #475569; }
    .detail-list dd:last-child, .detail-list dt:nth-last-of-type(1) { border-bottom: 0; }
    .detail-table th { color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.03em; }
    .detail-table td, .detail-table th { padding: 0.9rem 1rem; }
</style>

@endsection