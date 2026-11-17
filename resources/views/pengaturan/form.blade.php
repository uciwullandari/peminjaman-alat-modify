@extends('layouts.utama')

@section('judul', 'Pengaturan Sistem')

@section('content') <!-- Ubah menjadi content di sini -->
    <div class="container py-4 pengaturan-page">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Pengaturan Sistem</h3>
            <p class="text-muted mb-0">Atur identitas sekolah dan aturan dasar peminjaman alat.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-9">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom px-4 py-3">
                        <h5 class="mb-1 fw-bold">Konfigurasi Aplikasi</h5>
                        <p class="mb-0 text-muted small">Perubahan akan digunakan pada transaksi dan laporan berikutnya.</p>
                    </div>
                    <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('pengaturan.perbarui') }}">
                        @csrf
                        @method('PUT')

                        <div class="setting-field">
                            <x-input name="nama_sekolah" label="Nama Sekolah" :value="$pengaturan['nama_sekolah'] ?? ''" required />
                        </div>
                        <div class="form-text mb-4">
                            Tercetak sebagai kop pada seluruh laporan PDF.
                        </div>

                        <div class="setting-field">
                            <x-input name="tarif_denda_harian" label="Tarif Denda Harian (Rupiah)" type="number" :value="$pengaturan['tarif_denda_harian'] ?? 0" min="0" step="500" required />
                        </div>
                        <div class="form-text mb-4">
                            Berlaku per hari keterlambatan, per unit alat.<br>
                            Nilai ini dibaca langsung oleh trigger perhitungan denda.
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <x-input name="default_hari_pinjam" label="Durasi Pinjam Bawaan (hari)" type="number" :value="$pengaturan['default_hari_pinjam'] ?? 7" min="1" required />
                            </div>
                            <div class="col-md-6">
                                <x-input name="maks_hari_pinjam" label="Durasi Pinjam Maksimal (hari)" type="number" :value="$pengaturan['maks_hari_pinjam'] ?? 30" min="1" max="365" required />
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 rounded-3 small px-3 py-3 mb-4">
                            Perubahan tarif denda hanya berlaku untuk pengembalian yang diverifikasi <strong>setelah</strong> perubahan disimpan.<br>
                            Denda transaksi yang sudah selesai tidak dihitung ulang.
                        </div>

                        <button type="submit" class="btn btn-primary rounded-3 px-4 py-2 fw-semibold">Simpan Pengaturan</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pengaturan-page h3,
        .pengaturan-page h5 {
            color: #172033;
        }

        .pengaturan-page .form-control,
        .pengaturan-page .form-select {
            border-color: #dbe3ec;
            border-radius: 8px;
            padding: 0.65rem 0.8rem;
        }

        .pengaturan-page .form-control:focus,
        .pengaturan-page .form-select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.12);
        }

        .pengaturan-page .form-text {
            color: #64748b;
            line-height: 1.55;
        }
    </style>
@endsection
