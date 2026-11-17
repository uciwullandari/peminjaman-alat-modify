<table class="table table-hover align-middle mb-0 persetujuan-table">
    <thead class="bg-light">
        <tr>
            <th class="ps-4 py-3">Kode Pinjam</th>
            <th class="py-3">Peminjam</th>
            <th class="py-3">Tanggal Pinjam</th>
            <th class="py-3">Harus Kembali</th>
            <th class="py-3 text-center">Jumlah Alat</th>
            <th class="pe-4 py-3 text-center" style="width: 120px">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($daftarPengajuan as $peminjaman)
            <tr>
                <td class="ps-4 fw-semibold">{{ $peminjaman->kode_pinjam }}</td>

                <td>{{ $peminjaman->peminjam?->nama ?? '-' }}</td>

                <td class="text-muted">
                    {{ $peminjaman->tgl_pinjam->format('d/m/Y') }}
                </td>

                <td class="text-muted">
                    {{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}
                </td>

                <td class="text-center">
                    {{ $peminjaman->detail->sum('jumlah') }}
                </td>

                <td class="pe-4 text-center">
                    <a
                        href="{{ route('persetujuan.rincian', $peminjaman) }}"
                        class="btn btn-sm btn-primary rounded-pill px-3"
                    >
                        Proses
                    </a>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                    Tidak ada pengajuan yang menunggu diproses.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<style>
    .persetujuan-table thead th {
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .03em;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .persetujuan-table tbody td {
        border-color: #e2e8f0;
        padding-top: 1rem;
        padding-bottom: 1rem;
        white-space: nowrap;
    }
</style>