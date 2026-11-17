@extends('layouts.utama')
@section('judul', 'Koreksi Peminjaman')
@section('content')
    <div class="container py-4 koreksi-form-page">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Koreksi Peminjaman</h3>
                <p class="text-muted mb-0">Perbarui informasi peminjaman yang masih dapat dikoreksi.</p>
            </div>
            <a href="{{ route('koreksi.peminjaman.daftar') }}" class="btn btn-light border rounded-3 px-3 py-2 fw-semibold text-secondary">
                Kembali
            </a>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden summary-card">
                    <div class="card-header bg-white border-bottom px-4 py-3">
                        <h5 class="mb-1 fw-bold">Data Peminjaman</h5>
                        <p class="mb-0 text-muted small">Informasi ini tidak dapat diubah.</p>
                    </div>
                    <div class="card-body px-4 py-3">
                        <dl class="row gy-3 mb-0">
                        <dt class="col-5 text-muted">Kode Pinjam</dt>
                        <dd class="col-7 fw-semibold">{{ $peminjaman->kode_pinjam }}</dd>

                        <dt class="col-5 text-muted">Peminjam</dt>
                        <dd class="col-7 fw-semibold">{{ $peminjaman->peminjam?->nama ?? '-' }}</dd>

                        <dt class="col-5 text-muted">Status</dt>
                        <dd class="col-7">
                            <span class="badge rounded-pill bg-{{ $peminjaman->status->warna() }} px-3 py-2">
                                {{ $peminjaman->status->label() }}
                            </span>
                        </dd>

                        <dt class="col-5 text-muted">Daftar Alat</dt>
                        <dd class="col-7 mb-0">
                            <ul class="list-unstyled equipment-list mb-0">
                                @foreach($peminjaman->detail as $baris)
                                    <li class="mb-2">{{ $baris->alat->nama }} <span class="text-muted">({{ $baris->jumlah }})</span></li>
                                @endforeach
                            </ul>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom px-4 py-3">
                        <h5 class="mb-1 fw-bold">Isian yang Dapat Dikoreksi</h5>
                        <p class="mb-0 text-muted small">Perubahan akan tercatat di log aktivitas.</p>
                    </div>
                    <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('koreksi.peminjaman.perbarui', $peminjaman) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="tgl_pinjam" class="form-label fw-semibold">Tanggal Pinjam</label>
                            <input type="date" class="form-control @error('tgl_pinjam') is-invalid @enderror" id="tgl_pinjam" name="tgl_pinjam" value="{{ old('tgl_pinjam', $peminjaman->tgl_pinjam->toDateString()) }}" required>
                            @error('tgl_pinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tgl_harus_kembali" class="form-label fw-semibold">Tanggal Harus Kembali</label>
                            <input type="date" class="form-control @error('tgl_harus_kembali') is-invalid @enderror" id="tgl_harus_kembali" name="tgl_harus_kembali" value="{{ old('tgl_harus_kembali', $peminjaman->tgl_harus_kembali->toDateString()) }}" required>
                            @error('tgl_harus_kembali')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="keperluan" class="form-label fw-semibold">Keperluan</label>
                            <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan" rows="3">{{ old('keperluan', $peminjaman->keperluan) }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alasan_tolak" class="form-label fw-semibold">Alasan Tolak</label>
                            <textarea class="form-control @error('alasan_tolak') is-invalid @enderror" id="alasan_tolak" name="alasan_tolak" rows="3">{{ old('alasan_tolak', $peminjaman->alasan_tolak) }}</textarea>
                            @error('alasan_tolak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-text bg-light rounded-3 px-3 py-2 mb-4">
                            <small>Hanya keempat isian di atas yang boleh dikoreksi.</small>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Simpan Koreksi</button>
                            <a href="{{ route('koreksi.peminjaman.daftar') }}" class="btn btn-light border rounded-3 px-4 fw-semibold text-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .koreksi-form-page h3,
        .koreksi-form-page h5 {
            color: #172033;
        }

        .koreksi-form-page .form-control {
            border-color: #dbe3ec;
            border-radius: 8px;
            padding: 0.65rem 0.8rem;
        }

        .koreksi-form-page textarea.form-control {
            min-height: 96px;
        }

        .koreksi-form-page .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.12);
        }

        .koreksi-form-page dt,
        .koreksi-form-page dd {
            margin-bottom: 0;
        }

        .koreksi-form-page .equipment-list li:last-child {
            margin-bottom: 0 !important;
        }
    </style>
@endsection
