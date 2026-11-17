@extends('layouts.utama')

@section('judul', 'Rincian Peminjaman')

@section('content')

    <div class="container py-4 pemantauan-detail-page">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Rincian Peminjaman</h3>
                <p class="text-muted mb-0">Detail peminjaman yang sedang berlangsung.</p>
            </div>
            <a href="{{ route('pemantauan.index') }}" class="btn btn-light border rounded-3 px-3 fw-semibold text-secondary">Kembali</a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">

            <table class="table align-middle detail-table mb-4">

                <tr>
                    <th style="width: 220px;">Kode Peminjaman</th>
                    <td>
                        {{ $peminjaman->kode_pinjam }}
                    </td>
                </tr>

                <tr>
                    <th>Peminjam</th>
                    <td>
                        {{ $peminjaman->peminjam->nama ?? 'Tidak diketahui' }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Pinjam</th>
                    <td>
                        {{ $peminjaman->tgl_pinjam?->format('d/m/Y') ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Harus Kembali</th>
                    <td>
                        {{ $peminjaman->tgl_harus_kembali?->format('d/m/Y') ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        {{ $peminjaman->status?->label() ?? $peminjaman->status ?? '-' }}
                    </td>
                </tr>

            </table>

        </div>
    </div>

    <style>
        .pemantauan-detail-page h3 { color: #172033; }
        .detail-table th {
            width: 220px;
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
        }
        .detail-table th, .detail-table td {
            border-color: #e2e8f0;
            padding: .9rem 1rem;
        }
    </style>

@endsection
