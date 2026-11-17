<div class="loan-panel">
    <div class="card-header bg-white border-bottom px-4 py-3"><i class="bi bi-calendar2-check text-primary me-2"></i>Data Peminjaman</div>

    <div class="card-body p-4">
        @error('keranjang')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('peminjaman.simpan') }}">
            @csrf

            <x-input
                label="Tanggal Pinjam"
                type="date"
                name="tgl_pinjam"
                :value="old('tgl_pinjam', now()->toDateString())"
                required
            />

            <x-input
                label="Tanggal Harus Kembali"
                type="date"
                name="tgl_harus_kembali"
                :value="old('tgl_harus_kembali', now()->addDays($defaultHari)->toDateString())"
                required
            />

            <div class="form-text">
                Durasi awalan {{ $defaultHari }} hari, maksimal {{ $maksHari }} hari.
            </div>

            <x-textarea
                label="Keperluan"
                name="keperluan"
                :value="old('keperluan')"
            />

            <button
                type="submit"
                class="btn btn-primary w-100 rounded-3 py-2"
                {{ $daftarTunggakan->isNotEmpty() ? 'disabled' : '' }}
            >
                <i class="bi bi-send me-1"></i> Kirim Pengajuan
            </button>

            <a
                href="{{ route('katalog.keranjang') }}"
                class="btn btn-light border w-100 mt-2 rounded-3 py-2"
            >
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
            </a>
        </form>
    </div>
</div>

<style>
    .loan-panel { background: #fff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 0.125rem 0.35rem rgba(15, 23, 42, 0.04); }
    .loan-table th { white-space: nowrap; }
    .loan-table td, .loan-table th { padding: 0.85rem 1rem; }
    .cart-table th { color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.03em; white-space: nowrap; }
    .cart-table td, .cart-table th { padding: 0.9rem 0.55rem; }
    .cart-quantity { width: 70px; }
</style>