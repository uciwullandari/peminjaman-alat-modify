@extends('layouts.utama')

@section('judul', 'Pemantauan Peminjaman')

@section('content')

    <div class="container py-4 pemantauan-page">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Pemantauan Peminjaman</h3>
            <p class="text-muted mb-0">Pantau seluruh peminjaman alat yang sedang berlangsung.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 pemantauan-table">

                    <thead>
                        <tr>
                            <th class="ps-4 py-3" style="width: 50px;">No</th>
                            <th class="py-3">Kode Pinjam</th>
                            <th class="py-3">Peminjam</th>
                            <th class="py-3">Tanggal Pinjam</th>
                            <th class="py-3">Harus Kembali</th>
                            <th class="py-3">Status</th>
                            <th class="pe-4 py-3 text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($daftarPeminjaman as $peminjaman)

                            <tr>
                                <td class="ps-4 text-muted">
                                    {{ $daftarPeminjaman->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $peminjaman->kode_pinjam }}
                                </td>

                                <td class="text-muted">
                                    {{ $peminjaman->peminjam->nama ?? 'Tidak diketahui' }}
                                </td>

                                <td class="text-muted">
                                    {{ $peminjaman->tgl_pinjam?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>
                                    {{ $peminjaman->tgl_harus_kembali?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                        {{ $peminjaman->status?->label() ?? $peminjaman->status ?? '-' }}
                                    </span>
                                </td>

                                <td class="pe-4 text-center">
                                    <a
                                        href="{{ route('pemantauan.rincian', $peminjaman) }}"
                                        class="btn btn-sm btn-primary rounded-pill px-3"
                                    >
                                        Rincian
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Tidak ada peminjaman yang sedang berlangsung.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <div class="pagination-wrap px-4 py-3">
                {{ $daftarPeminjaman->links() }}
            </div>

        </div>
    </div>

    <style>
        .pemantauan-page h3 { color: #172033; }
        .pemantauan-table thead th {
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }
        .pemantauan-table tbody td {
            border-color: #e2e8f0;
            padding-top: 1rem;
            padding-bottom: 1rem;
            white-space: nowrap;
        }
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
    </style>

@endsection
