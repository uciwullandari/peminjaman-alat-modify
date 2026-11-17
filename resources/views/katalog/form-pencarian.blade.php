<form method="GET" action="{{ route('katalog.daftar') }}" class="catalog-filter row g-2 mb-4" data-live-search>
    <div class="col-lg-5 col-md-6">
        <label for="cari" class="visually-hidden">Cari alat</label>
        <input type="text" id="cari" name="cari" class="form-control"
            placeholder="Cari nama alat" value="{{ $kataKunci }}">
    </div>

    <div class="col-lg-4 col-md-6">
        <label for="kategori_id" class="visually-hidden">Pilih kategori</label>
        <select id="kategori_id" name="kategori_id" class="form-select">
            <option value="">Semua Kategori</option>

            @foreach ($daftarKategori as $kategori)
                <option value="{{ $kategori->id }}"
                    {{ $kategoriId == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-grow-1">Cari Alat</button>
        <a href="{{ route('katalog.daftar') }}" class="btn btn-light border">Reset</a>
    </div>
</form>

<script>
    (() => {
        const form = document.querySelector('[data-live-search]');
        const input = form?.querySelector('[name="cari"]');
        let timer;

        input?.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => form.requestSubmit(), 350);
        });
    })();
</script>