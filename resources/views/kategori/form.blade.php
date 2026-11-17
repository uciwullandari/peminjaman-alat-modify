@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            
            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('kategori.index') }}" class="btn btn-link text-decoration-none text-muted p-0 mb-3 d-inline-flex align-items-center gap-2 hover-back">
                &larr; Kembali ke Daftar Kategori
            </a>

            {{-- MAIN CARD CLEAN --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    
                    {{-- HEADER SIMPEL --}}
                    <div class="mb-4">
                        <h4 class="fw-bold mb-1" style="color: #0c4a6e;">
                            {{ $kategori->exists ? 'Ubah Kategori' : 'Tambah Kategori Baru' }}
                        </h4>
                        <p class="text-muted small mb-0">Isi informasi kategori di bawah ini.</p>
                    </div>

                    <form action="{{ $kategori->exists ? route('kategori.update', $kategori->id) : route('kategori.store') }}" method="POST">
                        @csrf
                        @if($kategori->exists)
                            @method('PUT')
                        @endif

                        {{-- INPUT NAMA --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold text-dark small">
                                NAMA KATEGORI <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" 
                                class="form-control border-1 rounded-3 py-2 @error('nama') is-invalid @enderror" 
                                value="{{ old('nama', $kategori->nama) }}" 
                                placeholder="Contoh: Perangkat Jaringan" 
                                required autofocus>
                            @error('nama')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INPUT DESKRIPSI --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold text-dark small">
                                DESKRIPSI
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                class="form-control border-1 rounded-3 py-2 @error('deskripsi') is-invalid @enderror" 
                                placeholder="Tuliskan keterangan singkat kategori di sini..." 
                                style="resize: none;">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- FOOTER / TOMBOL ACTION --}}
                        <div class="d-flex justify-content-end align-items-center gap-2 pt-2">
                            <a href="{{ route('kategori.index') }}" class="btn btn-light fw-medium px-4 py-2 rounded-3 text-muted">
                                Batal
                            </a>
                            <button type="submit" class="btn text-white fw-medium px-4 py-2 rounded-3 shadow-sm" style="background-color: #0284c7;">
                                {{ $kategori->exists ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .hover-back:hover {
        color: #0284c7 !important;
    }
    .form-control:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 0.25rem rgba(2, 132, 199, 0.15);
    }
</style>
@endsection