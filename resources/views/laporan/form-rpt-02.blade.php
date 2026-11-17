<div class="card laporan-card h-100">
    <div class="card-header">
        <span class="text-success me-2">02</span> Laporan Pengembalian &amp; Denda
    </div>

    <div class="card-body">
        <form method="GET"
              action="{{ route('laporan.pengembalian') }}"
              target="_blank">

            <div class="mb-2">
                <label class="form-label small">
                    Tanggal Awal
                </label>

                <input
                    type="date"
                    name="tgl_awal"
                    class="form-control form-control-sm"
                    value="{{ now()->startOfMonth()->toDateString() }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label small">
                    Tanggal Akhir
                </label>

                <input
                    type="date"
                    name="tgl_akhir"
                    class="form-control form-control-sm"
                    value="{{ now()->toDateString() }}"
                    required
                >
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
