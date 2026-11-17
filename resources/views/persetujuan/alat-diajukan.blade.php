<div class="card persetujuan-card">
    <div class="card-header">
        Alat yang Diajukan
    </div>

    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0 detail-table">
            <thead class="bg-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Alat</th>
                    <th class="text-center">Diminta</th>
                    <th class="text-center">Tersedia</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($peminjaman->detail as $baris)
                    <tr class="{{ $baris->alat->stok_tersedia < $baris->jumlah ? 'table-danger' : '' }}">
                        <td>
                            {{ $baris->alat->kode_alat }}
                        </td>

                        <td>
                            {{ $baris->alat->nama }}
                        </td>

                        <td class="text-center">
                            {{ $baris->jumlah }}
                        </td>

                        <td class="text-center">
                            {{ $baris->alat->stok_tersedia }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-3 persetujuan-card">
    <div class="card-body">
        <dl class="row mb-0">

            <dt class="col-sm-4 text-muted">
                Peminjam
            </dt>

            <dd class="col-sm-8">
                {{ $peminjaman->peminjam->nama }}
            </dd>

            <dt class="col-sm-4 text-muted">
                Tanggal Pinjam
            </dt>

            <dd class="col-sm-8">
                {{ $peminjaman->tgl_pinjam->format('d/m/Y') }}
            </dd>

            <dt class="col-sm-4 text-muted">
                Keperluan
            </dt>

            <dd class="col-sm-8">
                {{ $peminjaman->keperluan ?? '-' }}
            </dd>

        </dl>
    </div>
</div>

<style>
    .detail-table th {
        color: #475569;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .03em;
        white-space: nowrap;
    }
    .detail-table th, .detail-table td {
        border-color: #e2e8f0;
        padding: .85rem 1rem;
    }
</style>