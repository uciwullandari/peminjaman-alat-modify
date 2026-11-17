<div class="card mb-3 persetujuan-card">
    <div class="card-header">
        Setujui
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('persetujuan.setujui', $peminjaman) }}">

            @csrf

            <x-input
                label="Tanggal Harus Kembali"
                name="tgl_harus_kembali"
                type="date"
                value="{{ $peminjaman->tgl_harus_kembali->toDateString() }}"
                required
            />

            <button type="submit" class="btn btn-success rounded-3 w-100 py-2 fw-semibold">
                Setujui Peminjaman
            </button>

        </form>
    </div>
</div>

<div class="card persetujuan-card">
    <div class="card-header">
        Tolak
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('persetujuan.tolak', $peminjaman) }}">

            @csrf

            <x-textarea
                label="Alasan Penolakan"
                name="alasan_tolak"
                rows="3"
            />

            <button type="submit" class="btn btn-danger rounded-3 w-100 py-2 fw-semibold">
                Tolak Peminjaman
            </button>

        </form>
    </div>
</div>

<style>
    .persetujuan-card .form-control {
        border-color: #dbe3ec;
        border-radius: 8px;
    }

    .persetujuan-card .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .12);
    }
</style>