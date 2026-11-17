<table class="table table-hover align-middle mb-0 verifikasi-table">
    <thead class="bg-light">
        <tr>
            <th class="ps-4 py-3">Kode Pinjam</th>
            <th class="py-3">Peminjam</th>
            <th class="py-3">Diajukan Kembali</th>
            <th class="py-3">Harus Kembali</th>
            <th class="py-3 text-center">Jumlah Alat</th>
            <th class="pe-4 py-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($daftarAntrian as $peminjaman)
            <tr class="{{ $peminjaman->lewatTenggat() ? 'table-warning' : '' }}">
                <td class="ps-4 fw-semibold">{{ $peminjaman->kode_pinjam }}</td>
                <td>{{ $peminjaman->peminjam?->nama ?? '-' }}</td>

                <td class="text-muted">
                    {{ $peminjaman->tgl_diajukan_kembali?->format('d/m/Y') ?? '-' }}
                </td>

                <td class="text-muted">
                    {{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}

                    @if ($peminjaman->lewatTenggat())
                        <span class="badge rounded-pill bg-danger px-2 py-1">
                            Terlambat
                            {{ $peminjaman->tgl_harus_kembali->diffInDays(now()) }} hari
                        </span>
                    @endif
                </td>

                <td class="text-center fw-semibold">
                    {{ $peminjaman->detail->count() }}
                </td>

                <td class="pe-4 text-center">
                    <a href="{{ route('pengembalian.verifikasi', $peminjaman) }}"
                       class="btn btn-sm btn-primary rounded-pill px-3">
                        Verifikasi
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                    Tidak ada pengajuan pengembalian yang menunggu verifikasi.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<style>
    .verifikasi-table thead th {
        color: #475569; font-size: 12px; font-weight: 700; letter-spacing: .03em;
        text-transform: uppercase; border-bottom: 1px solid #e2e8f0; white-space: nowrap;
    }
    .verifikasi-table tbody td {
        border-color: #e2e8f0; padding-top: 1rem; padding-bottom: 1rem; white-space: nowrap;
    }
</style>