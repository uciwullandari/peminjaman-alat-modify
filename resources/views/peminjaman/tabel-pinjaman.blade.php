<table class="table history-table align-middle mb-0">
    <thead>
        <tr>
            <th>Kode Pinjam</th>
            <th>Tanggal Pinjam</th>
            <th>Harus Kembali</th>
            <th class="text-center">Jumlah Alat</th>
            <th>Status</th>
            <th class="history-actions">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($daftarPeminjaman as $peminjaman)
            <tr>
                <td class="fw-semibold text-primary">{{ $peminjaman->kode_pinjam }}</td>

                <td>
                    {{ $peminjaman->tgl_pinjam->format('d/m/Y') }}
                </td>

                <td>
                    {{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}

                    @if ($peminjaman->lewatTenggat())
                        <span class="badge rounded-pill bg-danger-subtle text-danger d-block mt-1" style="width: fit-content;">
                            <i class="bi bi-exclamation-circle me-1"></i>Lewat tenggat
                        </span>
                    @endif
                </td>

                <td class="text-center">
                    <span class="badge rounded-pill bg-light text-dark">{{ $peminjaman->detail->count() }} alat</span>
                </td>

                <td>
                    <span class="badge rounded-pill bg-{{ $peminjaman->status->warna() }}">
                        {{ $peminjaman->status->label() }}
                    </span>
                </td>

                <td>
                    <a href="{{ route('peminjaman.rincian', $peminjaman) }}" class="btn btn-sm btn-outline-primary rounded-3">
                        <i class="bi bi-eye me-1"></i>Rincian
                    </a>

                    @if ($peminjaman->status->value === 'dipinjam')
                        <form action="{{ route('pengembalian.ajukan', $peminjaman) }}"
                              method="POST"
                              class="d-inline">
                            @csrf

                            <button type="submit"
                                    class="btn btn-sm btn-success rounded-3">
                                <i class="bi bi-arrow-return-left me-1"></i>Kembalikan
                            </button>
                        </form>
                    @endif
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-5">
                    <i class="bi bi-inbox d-block mb-2" style="font-size: 2rem;"></i>
                    Belum ada pengajuan peminjaman.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>