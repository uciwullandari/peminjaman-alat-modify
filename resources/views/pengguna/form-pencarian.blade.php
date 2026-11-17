<form action="{{ route('pengguna.index') }}" method="GET" class="row g-2 align-items-center">
    <div class="col-md-6 col-12">
        <input type="text" name="cari" class="form-control bg-light border-0 py-2 rounded-3 fs-6" placeholder="Cari nama atau nama pengguna..." value="{{ request('cari') }}" autocomplete="off">
    </div>

    <div class="col-md-3 col-12">
        <select name="peran" class="form-select bg-light border-0 py-2 rounded-3 fs-6">
            <option value="">Semua Peran</option>
            <option value="admin" {{ request('peran') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="petugas" {{ request('peran') == 'petugas' ? 'selected' : '' }}>Petugas</option>
            <option value="peminjam" {{ request('peran') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
        </select>
    </div>

    <div class="col-md-3 col-12 d-flex gap-2">
        <button type="submit" class="btn btn-light border fw-medium rounded-3 px-3 py-2 flex-grow-1">
            Filter
        </button>
        @if(request('cari') || request('peran'))
            <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2">
                Reset
            </a>
        @endif
    </div>
</form>