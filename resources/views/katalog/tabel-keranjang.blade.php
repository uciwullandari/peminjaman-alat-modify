<table class="table cart-table align-middle mb-0">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Alat</th>
            <th>Kategori</th>
            <th class="text-center">Tersedia</th>
            <th style="width: 160px">Jumlah Pinjam</th>
            <th style="width: 90px">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($isiKeranjang as $baris)
            <tr>
                <td class="text-muted small fw-semibold">{{ $baris->alat->kode_alat }}</td>
                <td class="fw-semibold">{{ $baris->alat->nama }}</td>
                <td class="text-muted">{{ $baris->alat->kategori->nama }}</td>
                <td class="text-center"><span class="badge rounded-pill bg-success-subtle text-success">{{ $baris->alat->stok_tersedia }}</span></td>

                <td>
                    <form method="POST"
                        action="{{ route('katalog.ubah-jumlah', $baris->alat) }}"
                        class="d-flex gap-1">
                        @csrf
                        @method('PUT')

                        <input type="number"
                            name="jumlah"
                            class="form-control form-control-sm cart-quantity"
                            value="{{ $baris->jumlah }}"
                            min="1"
                            max="{{ $baris->alat->stok_tersedia }}">

                        <button type="submit"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-check2"></i><span class="d-none d-lg-inline ms-1">Ubah</span>
                        </button>
                    </form>
                </td>

                <td>
                    <form method="POST"
                        action="{{ route('katalog.hapus', $baris->alat->id) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash3"></i><span class="d-none d-lg-inline ms-1">Hapus</span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>