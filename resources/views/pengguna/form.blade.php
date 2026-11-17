@extends('layouts.utama')

@section('judul', $pengguna->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')

@section('content')
<div class="container-fluid py-3" style="max-width: 900px;">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-4">
        <a href="{{ route('pengguna.index') }}" class="text-decoration-none text-muted small fw-semibold d-inline-flex align-items-center gap-1 mb-2 hover-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
        <h3 class="fw-bold text-dark mb-0">{{ $pengguna->exists ? 'Ubah Data Pengguna' : 'Tambah Pengguna Baru' }}</h3>
    </div>

    {{-- CARD FORM --}}
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <form action="{{ $pengguna->exists ? route('pengguna.update', $pengguna) : route('pengguna.store') }}" method="POST">
                @csrf
                @if($pengguna->exists)
                    @method('PUT')
                @endif

                <div class="row g-4">
                    {{-- NAMA LENGKAP --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary fs-7 mb-1">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <input type="text" name="nama" class="form-control bg-light border-start-0 rounded-end-3 fs-6 @error('nama') is-invalid @enderror" value="{{ old('nama', $pengguna->nama) }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                        @error('nama') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- NAMA PENGGUNA (USERNAME) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary fs-7 mb-1">Nama Pengguna (Username)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"/></svg>
                            </span>
                            <input type="text" name="username" class="form-control bg-light border-start-0 rounded-end-3 fs-6 @error('username') is-invalid @enderror" value="{{ old('username', $pengguna->username) }}" placeholder="Masukkan username" required>
                        </div>
                        @error('username') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary fs-7 mb-1">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </span>
                            <input type="email" name="email" class="form-control bg-light border-start-0 rounded-end-3 fs-6 @error('email') is-invalid @enderror" value="{{ old('email', $pengguna->email) }}" placeholder="contoh@sekolah.sch.id">
                        </div>
                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- NOMOR TELEPON --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary fs-7 mb-1">Nomor Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <input type="text" name="no_telp" class="form-control bg-light border-start-0 rounded-end-3 fs-6 @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $pengguna->no_telp) }}" placeholder="08xxxxxxxxxx">
                        </div>
                        @error('no_telp') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 my-1"><hr class="border-light-subtle"></div>

                    {{-- KATA SANDI --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary fs-7 mb-1">
                            Kata Sandi
                            @if($pengguna->exists)
                                <span class="fw-normal text-muted" style="font-size: 11px;">(Kosongkan bila tidak diganti)</span>
                            @endif
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            <input type="password" name="password" class="form-control bg-light border-start-0 rounded-end-3 fs-6 @error('password') is-invalid @enderror" placeholder="••••••••">
                        </div>
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- KONFIRMASI KATA SANDI --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary fs-7 mb-1">Konfirmasi Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                            </span>
                            <input type="password" name="password_confirmation" class="form-control bg-light border-start-0 rounded-end-3 fs-6" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="col-12 my-1"><hr class="border-light-subtle"></div>

                    {{-- PERAN --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary fs-7 mb-1">Peran Akses</label>
                        <select name="peran" class="form-select bg-light rounded-3 fs-6 py-2.5 @error('peran') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Peran --</option>
                            @foreach($daftarPeran as $item)
                                @php
                                    $selected = old('peran', $pengguna->roles->first()->name ?? '') == $item->name ? 'selected' : '';
                                @endphp
                                <option value="{{ $item->name }}" {{ $selected }}>{{ ucfirst($item->name) }}</option>
                            @endforeach
                        </select>
                        @error('peran') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary fs-7 mb-1">Status Akun</label>
                        <select name="is_aktif" class="form-select bg-light rounded-3 fs-6 py-2.5 @error('is_aktif') is-invalid @enderror" required>
                            <option value="1" {{ old('is_aktif', $pengguna->is_aktif ?? 1) == 1 ? 'selected' : '' }}>● Aktif</option>
                            <option value="0" {{ old('is_aktif', $pengguna->is_aktif ?? 1) == 0 ? 'selected' : '' }}>● Nonaktif</option>
                        </select>
                        @error('is_aktif') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="d-flex justify-content-end align-items-center gap-2 mt-5 pt-3 border-top">
                    <a href="{{ route('pengguna.index') }}" class="btn btn-light px-4 py-2 rounded-pill fw-semibold text-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fs-7 { font-size: 13px; }
    .form-control, .form-select, .input-group-text {
        border-color: #e5e7eb;
    }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .hover-primary:hover {
        color: #0284c7 !important;
    }
</style>
@endsection