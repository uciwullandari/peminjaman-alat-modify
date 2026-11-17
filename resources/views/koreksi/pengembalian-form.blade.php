@extends('layouts.utama')

@section('judul', 'Ubah Koreksi Pengembalian')

@section('content')
    <div class="container py-4 koreksi-pengembalian-page">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Koreksi Pengembalian</h3>
                <p class="text-muted mb-0">Perbarui denda kerusakan pada data pengembalian.</p>
            </div>
            <a href="{{ route('koreksi.pengembalian.daftar') }}" class="btn btn-light border rounded-3 px-3 py-2 fw-semibold text-secondary">
                Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom px-4 py-3">
                        <h5 class="mb-1 fw-bold">Ubah Data Pengembalian</h5>
                        <p class="mb-0 text-muted small">Pastikan nilai denda sudah sesuai sebelum disimpan.</p>
                    </div>
                    <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('koreksi.pengembalian.perbarui', $pengembalian->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-semibold">ID Transaksi</label>
                            <input type="text" class="form-control bg-light" value="#{{ $pengembalian->id }}" disabled>
                        </div>

                        <div class="mb-4">
                            <label for="denda_kerusakan" class="form-label fw-semibold">Denda Kerusakan (Rupiah)</label>
                            <input id="denda_kerusakan" name="denda_kerusakan" type="number" class="form-control @error('denda_kerusakan') is-invalid @enderror" value="{{ old('denda_kerusakan', $pengembalian->denda_kerusakan ?? 0) }}" min="0" step="500" required>
                            @error('denda_kerusakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status Pengembalian</label>
                            <input type="text" class="form-control bg-light" value="{{ ucfirst($pengembalian->status ?? '-') }}" disabled>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Simpan Perubahan</button>
                            <a href="{{ route('koreksi.pengembalian.daftar') }}" class="btn btn-light border rounded-3 px-4 fw-semibold text-secondary">Batal</a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .koreksi-pengembalian-page h3,
        .koreksi-pengembalian-page h5 {
            color: #172033;
        }

        .koreksi-pengembalian-page .form-control {
            border-color: #dbe3ec;
            border-radius: 8px;
            padding: 0.65rem 0.8rem;
        }

        .koreksi-pengembalian-page .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.12);
        }
    </style>
@endsection
