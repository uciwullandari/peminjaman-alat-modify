@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- HERO BANNER SAMBUTAN --}}
    <div class="p-4 p-md-5 mb-4 rounded-4 shadow-sm text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
        <div class="position-relative z-1">
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="font-size: 12px;">
                Dashboard Administrator
            </span>
            <h2 class="fw-bold mb-2">Selamat Datang, {{ auth()->user()->nama ?? 'Administrator' }}! 👋</h2>
            <p class="mb-0 text-light opacity-75" style="max-width: 600px;">
                Pantau seluruh aktivitas peminjaman, ketersediaan inventaris alat, dan kelola pengguna dalam satu tempat secara efisien.
            </p>
        </div>
        <div class="position-absolute end-0 bottom-0 opacity-10 d-none d-md-block pe-4 pb-2" style="font-size: 140px; line-height: 0; pointer-events: none;">
            🛠️
        </div>
    </div>

    {{-- CARD STATISTIK / RINGKASAN DATA --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Total Alat</span>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalAlat }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #e0f2fe; color: #0284c7;">
                        🧰
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Sedang Dipinjam</span>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalDipinjam }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #fef3c7; color: #d97706;">
                        📋
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Pengguna Aktif</span>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalPengguna }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #dcfce7; color: #15803d;">
                        👥
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Kategori Alat</span>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalKategori }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #e0e7ff; color: #4338ca;">
                        🏷️
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 p-4 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-1">Registrasi Peminjaman</h5>
                <p class="text-muted small mb-0">Daftar nama peminjam dan status pengajuan peminjaman alat.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill px-3 py-2" style="background-color: #fef3c7; color: #b45309;">
                    {{ $totalMenungguPersetujuan }} menunggu
                </span>
                <a href="{{ route('persetujuan.antrian') }}" class="btn btn-sm btn-primary rounded-3">Lihat Semua</a>
            </div>
        </div>

        <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary small">Kode Pinjam</th>
                            <th class="py-3 text-secondary small">Nama Peminjam</th>
                            <th class="py-3 text-secondary small">Tanggal Pinjam</th>
                            <th class="py-3 text-secondary small text-center">Jumlah Alat</th>
                            <th class="py-3 text-secondary small text-center">Status</th>
                            <th class="pe-4 py-3 text-secondary small text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registrasiPeminjamanTerbaru as $peminjaman)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $peminjaman->kode_pinjam }}</td>
                                <td>{{ $peminjaman->peminjam?->nama ?? '-' }}</td>
                                <td class="text-muted">{{ $peminjaman->tgl_pinjam->format('d/m/Y') }}</td>
                                <td class="text-center">{{ $peminjaman->detail->sum('jumlah') }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 py-2 bg-{{ $peminjaman->status->warna() }}">
                                        {{ $peminjaman->status->label() }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    @if ($peminjaman->status === \App\Enums\StatusPeminjaman::Diajukan)
                                        <a href="{{ route('persetujuan.rincian', $peminjaman) }}" class="btn btn-sm btn-outline-primary rounded-3">Proses</a>
                                    @else
                                        <span class="text-muted small">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada registrasi peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 p-4 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-1">Notifikasi Keterlambatan Pengembalian</h5>
                <p class="text-muted small mb-0">Peminjaman aktif yang melewati tanggal harus kembali.</p>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background-color: #ffe4e6; color: #be123c;">
                {{ $peminjamanTerlambat->count() }} terlambat
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small">Peminjam</th>
                        <th class="py-3 text-secondary small">Kode Pinjam</th>
                        <th class="py-3 text-secondary small">Jatuh Tempo</th>
                        <th class="py-3 text-secondary small text-center">Terlambat</th>
                        <th class="pe-4 py-3 text-secondary small text-end">Denda Saat Ini</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanTerlambat as $peminjaman)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $peminjaman->peminjam?->nama ?? '-' }}</td>
                            <td>{{ $peminjaman->kode_pinjam }}</td>
                            <td class="text-muted">{{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}</td>
                            <td class="text-center"><span class="badge bg-danger-subtle text-danger">{{ $peminjaman->hari_terlambat }} hari</span></td>
                            <td class="pe-4 text-end fw-semibold text-danger">Rp {{ number_format($peminjaman->denda_keterlambatan_saat_ini, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada pengembalian yang terlambat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">Tren Peminjaman Alat</h5>
                <p class="text-muted small mb-0">Jumlah transaksi berdasarkan status selama 6 bulan terakhir.</p>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background-color: #e0f2fe; color: #0369a1;">6 bulan terakhir</span>
        </div>
        <div style="height: 320px;">
            <canvas id="grafikPeminjaman" aria-label="Grafik data peminjaman alat" role="img"></canvas>
        </div>
    </div>

    {{-- MENU AKSES CEPAT (QUICK ACCESS) --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <h5 class="fw-bold text-dark mb-3">Akses Cepat</h5>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('kategori.index') }}" class="btn btn-light border p-3 w-100 rounded-3 text-start hover-card d-flex align-items-center gap-3">
                    <span class="fs-4">📂</span>
                    <div>
                        <div class="fw-bold text-dark">Kelola Kategori</div>
                        <small class="text-muted">Atur jenis alat</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('alat.index') }}" class="btn btn-light border p-3 w-100 rounded-3 text-start hover-card d-flex align-items-center gap-3">
                    <span class="fs-4">🔧</span>
                    <div>
                        <div class="fw-bold text-dark">Data Alat</div>
                        <small class="text-muted">Tambah/Edit barang</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('pengguna.index') }}" class="btn btn-light border p-3 w-100 rounded-3 text-start hover-card d-flex align-items-center gap-3">
                    <span class="fs-4">👤</span>
                    <div>
                        <div class="fw-bold text-dark">Kelola User</div>
                        <small class="text-muted">Manajemen akun</small>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>

<style>
    .hover-card {
        transition: all 0.2s ease;
    }
    .hover-card:hover {
        background-color: #f0f9ff !important;
        border-color: #bae6fd !important;
        transform: translateY(-2px);
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const dataPeminjaman = @json($grafikPeminjaman);

    new Chart(document.getElementById('grafikPeminjaman'), {
        type: 'line',
        data: {
            labels: dataPeminjaman.map((bulan) => bulan.label),
            datasets: [
                { label: 'Diajukan', data: dataPeminjaman.map((bulan) => bulan.diajukan), borderColor: '#f59e0b', backgroundColor: '#f59e0b', tension: 0.35 },
                { label: 'Dipinjam', data: dataPeminjaman.map((bulan) => bulan.dipinjam), borderColor: '#0284c7', backgroundColor: '#0284c7', tension: 0.35 },
                { label: 'Menunggu Pengembalian', data: dataPeminjaman.map((bulan) => bulan.menunggu_verifikasi), borderColor: '#0891b2', backgroundColor: '#0891b2', tension: 0.35 },
                { label: 'Selesai', data: dataPeminjaman.map((bulan) => bulan.selesai), borderColor: '#16a34a', backgroundColor: '#16a34a', tension: 0.35 },
                { label: 'Ditolak', data: dataPeminjaman.map((bulan) => bulan.ditolak), borderColor: '#e11d48', backgroundColor: '#e11d48', tension: 0.35 }
            ]
        },
        options: {
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18 } } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
</script>
@endsection