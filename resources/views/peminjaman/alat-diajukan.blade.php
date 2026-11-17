<div class="loan-panel h-100">
    <div class="card-header bg-white border-bottom px-4 py-3">
        <i class="bi bi-box-seam text-primary me-2"></i>Alat yang Diajukan
    </div>

    <div class="card-body p-0">
        <table class="table loan-table mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alat</th>
                    <th class="text-center">Jumlah</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($isiKeranjang as $baris)
                    <tr>
                        <td class="text-muted small fw-semibold">{{ $baris->alat->kode_alat }}</td>
                        <td class="fw-semibold">{{ $baris->alat->nama }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-primary-subtle text-primary">{{ $baris->jumlah }} unit</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>