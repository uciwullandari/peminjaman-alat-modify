@extends('layouts.utama')

@section('judul', 'Koreksi Data Pengembalian')

@section('content')
    <div class="container py-4 koreksi-pengembalian-page">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Koreksi Data Pengembalian</h3>
            <p class="text-muted mb-0">Periksa dan koreksi denda kerusakan pada data pengembalian.</p>
        </div>

    <div class="alert alert-info border-0 rounded-3 px-3 py-2 mb-4">
        <small>Data pengembalian tidak dapat dihapus. Yang dapat dikoreksi hanya denda kerusakan dan catatan.</small>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle koreksi-table">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Kode Pinjam</th>
                            <th class="py-3">Peminjam</th>
                            <th class="py-3">Tanggal Kembali</th>
                            <th class="py-3">Denda Keterlambatan</th>
                            <th class="py-3">Denda Kerusakan</th>
                            <th class="py-3">Total Denda</th>
                            <th class="pe-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $item)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $item->peminjaman->kode_pinjam ?? '-' }}</td>
                                <td>{{ $item->peminjaman->peminjam?->nama ?? '-' }}</td>
                                <td class="text-muted">{{ optional($item->tgl_kembali)->format('d/m/Y') ?? '-' }}</td>
                                <td>Rp {{ number_format($item->denda_keterlambatan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->denda_kerusakan, 0, ',', '.') }}</td>
                                <td class="fw-semibold">Rp {{ number_format($item->total_denda, 0, ',', '.') }}</td>
                                <td class="pe-4 text-center">
                                    <a href="{{ route('koreksi.pengembalian.ubah', $item->id) }}" class="btn btn-sm btn-warning rounded-pill px-3">Ubah</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3">Belum ada data pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .koreksi-pengembalian-page h3 {
            color: #172033;
        }

        .koreksi-pengembalian-page .koreksi-table thead th {
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .koreksi-pengembalian-page .koreksi-table tbody td {
            border-color: #e2e8f0;
            padding-top: 1rem;
            padding-bottom: 1rem;
            white-space: nowrap;
        }

    </style>
@endsection
