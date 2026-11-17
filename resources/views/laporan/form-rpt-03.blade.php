<div class="card laporan-card h-100">
    <div class="card-header">
        <span class="text-warning me-2">03</span> Rekapitulasi Stok Alat
    </div>

    <div class="card-body">
        <form method="GET"
              action="{{ route('laporan.stok') }}"
              target="_blank">

            <div class="mb-3">
                <label class="form-label small">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    class="form-select form-select-sm"
                >
                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach (($daftarKategori ?? collect()) as $kategori)
                        <option value="{{ $kategori->id }}">
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button
                type="submit"
                  class="btn btn-primary btn-cetak w-100"
            >
                Download Excel
            </button>

        </form>
    </div>
</div>
