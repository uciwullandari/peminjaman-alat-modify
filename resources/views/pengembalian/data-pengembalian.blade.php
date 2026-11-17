<div class="card verifikasi-card">
    <div class="card-header">Data Pengembalian</div>
    <div class="card-body">

        <dl class="row gy-2 small mb-3">
            <dt class="col-6 text-muted">Peminjam</dt>
            <dd class="col-6">{{ $peminjaman->peminjam->nama }}</dd>

            <dt class="col-6 text-muted">Harus Kembali</dt>
            <dd class="col-6">
                {{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}
            </dd>

            <dt class="col-6 text-muted">Diajukan Kembali</dt>
            <dd class="col-6">
                {{ $peminjaman->tgl_diajukan_kembali?->format('d/m/Y') ?? '-' }}
            </dd>
        </dl>

        <div class="form-text">
            Perubahan tanggal akan tercatat di log aktivitas.
        </div>

        <x-input
            name="tgl_kembali"
            type="date"
            label="Tanggal Kembali"
            :value="old('tgl_kembali', $peminjaman->tgl_diajukan_kembali?->toDateString() ?? now()->toDateString())"
            required
        />

        <div class="form-text">
            Denda keterlambatan dihitung sistem, tidak perlu diisi di sini.
        </div>

        <x-input
            name="denda_kerusakan"
            type="number"
            label="Denda Kerusakan"
            :value="old('denda_kerusakan', 0)"
            min="0"
            step="1000"
        />

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea
                class="form-control"
                id="catatan"
                name="catatan"
                rows="3"
            >{{ old('catatan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success rounded-3 w-100 py-2 fw-semibold">
            Simpan Verifikasi
        </button>

    </div>
</div>