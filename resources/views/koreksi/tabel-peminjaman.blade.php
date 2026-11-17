@isset($daftarPeminjaman)
<table class="table table-hover align-middle mb-0 koreksi-table">
    <thead class="bg-light">
        <tr>
            <th class="ps-4 py-3">Kode Pinjam</th>
            <th class="py-3">Peminjam</th>
            <th class="py-3">Tanggal Pinjam</th>
            <th class="py-3">Harus Kembali</th>
            <th class="py-3">Status</th>
            <th class="pe-4 py-3 text-center" style="width: 180px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($daftarPeminjaman as $peminjaman)
            <tr>
                <td class="ps-4 fw-semibold">{{ $peminjaman->kode_pinjam }}</td>
                <td>{{ $peminjaman->peminjam?->nama ?? '-' }}</td>
                <td class="text-muted">{{ $peminjaman->tgl_pinjam->format('d/m/Y') }}</td>
                <td class="text-muted">{{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}</td>
                <td>
                    <span class="badge rounded-pill bg-{{ $peminjaman->status->warna() }} px-3 py-2">
                        {{ $peminjaman->status->label() }}
                    </span>
                </td>
                <td class="pe-4 text-center">
                    <a href="{{ route('koreksi.peminjaman.ubah', $peminjaman) }}" class="btn btn-sm btn-warning rounded-pill px-3">Ubah</a>
                    @can('delete', $peminjaman)
                        <form method="POST" action="{{ route('koreksi.peminjaman.hapus', $peminjaman) }}" class="d-inline"
                            onsubmit="return confirm('Hapus data peminjaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Hapus</button>
                        </form>
                    @else
                        <button class="btn btn-sm btn-secondary rounded-pill px-3" disabled title="Hanya berstatus diajukan atau ditolak yang dapat dihapus">
                            Hapus
                        </button>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Belum ada data peminjaman.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<style>
    .koreksi-table thead th {
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .koreksi-table tbody td {
        border-color: #e2e8f0;
        padding-top: 1rem;
        padding-bottom: 1rem;
        white-space: nowrap;
    }

</style>
@endisset
