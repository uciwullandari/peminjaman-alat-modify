@extends('layouts.utama')

@section('judul', $alat->exists ? 'Edit Alat' : 'Tambah Alat Baru')

@section('content')
<div class="container-fluid py-3" style="max-width: 950px;">

    {{-- HEADER & BREADCRUMB --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('alat.index') }}" class="text-decoration-none text-muted small fw-semibold d-inline-flex align-items-center gap-1 mb-2 hover-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                <span>Kembali ke Daftar Alat</span>
            </a>
            <h3 class="fw-bold text-dark mb-1">{{ $alat->exists ? 'Ubah Data Alat' : 'Tambah Alat Baru' }}</h3>
            <p class="text-muted small mb-0">{{ $alat->exists ? 'Perbarui informasi dan ketersediaan alat di sistem.' : 'Isi formulir di bawah ini untuk menambahkan inventaris alat baru.' }}</p>
        </div>
    </div>

    {{-- CARD UTAMA FORM --}}
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-body p-4 p-md-5">

            <form action="{{ $alat->exists ? route('alat.update', $alat) : route('alat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($alat->exists)
                    @method('PUT')
                @endif

                <div class="row g-4">
                    
                    {{-- KODE ALAT --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark fs-7">Kode Alat <span class="text-danger">*</span></label>
                        <input type="text" name="kode_alat" class="form-control bg-light border-0 py-2.5 rounded-3 fs-6 @error('kode_alat') is-invalid @enderror" 
                               placeholder="Contoh: ALT-001" value="{{ old('kode_alat', $alat->kode_alat) }}" required>
                        @error('kode_alat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NAMA ALAT --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark fs-7">Nama Alat <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control bg-light border-0 py-2.5 rounded-3 fs-6 @error('nama') is-invalid @enderror" 
                               placeholder="Contoh: Proyektor Epson EB-X400" value="{{ old('nama', $alat->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- KATEGORI --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark fs-7">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select bg-light border-0 py-2.5 rounded-3 fs-6 @error('kategori_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('kategori_id', $alat->kategori_id) ? '' : 'selected' }}>-- Pilih Kategori --</option>
                            @foreach ($daftarKategori as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $alat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- KONDISI --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark fs-7">Kondisi Alat <span class="text-danger">*</span></label>
                        @php
                            $kondisiLama = strtolower(old('kondisi', $alat->kondisi ?? 'baik'));
                        @endphp
                        <select name="kondisi" class="form-select bg-light border-0 py-2.5 rounded-3 fs-6 @error('kondisi') is-invalid @enderror" required>
                            <option value="Baik" {{ in_array($kondisiLama, ['baik', 'Baik']) ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ in_array($kondisiLama, ['rusak ringan', 'rusak_ringan', 'Rusak Ringan']) ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ in_array($kondisiLama, ['rusak berat', 'rusak_berat', 'Rusak Berat']) ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        @error('kondisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- STOK TOTAL --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark fs-7">Stok Total <span class="text-danger">*</span></label>
                        <input type="number" name="stok_total" min="0" class="form-control bg-light border-0 py-2.5 rounded-3 fs-6 @error('stok_total') is-invalid @enderror" 
                               placeholder="Contoh: 10" value="{{ old('stok_total', $alat->stok_total ?? $alat->stok) }}" required>
                        @error('stok_total')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- STOK TERSEDIA --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark fs-7">Stok Tersedia <span class="text-danger">*</span></label>
                        <input type="number" name="stok_tersedia" min="0" class="form-control bg-light border-0 py-2.5 rounded-3 fs-6 @error('stok_tersedia') is-invalid @enderror" 
                               placeholder="Contoh: 10" value="{{ old('stok_tersedia', $alat->stok_tersedia ?? $alat->stok_total ?? $alat->stok) }}" required>
                        @error('stok_tersedia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark fs-7">Deskripsi Alat</label>
                        <textarea name="deskripsi" rows="3" class="form-control bg-light border-0 p-3 rounded-3 fs-6 @error('deskripsi') is-invalid @enderror" 
                                  placeholder="Tuliskan spesifikasi atau rincian keterangan alat...">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FOTO ALAT --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark fs-7">
                            Foto Alat <span class="text-muted fw-normal fs-8">{{ $alat->exists ? '(Kosongkan jika tidak diubah)' : '(Opsional)' }}</span>
                        </label>
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="preview-box border rounded-3 d-flex align-items-center justify-content-center bg-light overflow-hidden" style="width: 80px; height: 80px; flex-shrink: 0;">
                                @if ($alat->exists && $alat->foto)
                                    <img id="imgPreview" src="{{ asset('gambar/alat/' . $alat->foto) }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <img id="imgPreview" src="" class="w-100 h-100 object-fit-cover d-none">
                                    <div id="placeholderPreview" class="text-center text-muted p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="foto" id="fotoInput" class="form-control bg-light border-0 py-2 rounded-3 fs-6 @error('foto') is-invalid @enderror" accept="image/*" onchange="previewImage(event)">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="my-4 text-muted opacity-25">

                {{-- TOMBOL AKSI --}}
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('alat.index') }}" class="btn btn-light px-4 py-2 rounded-3 fw-semibold text-muted text-decoration-none">
                        Batal
                    </a>
                    <button type="submit" class="btn text-white px-4 py-2 rounded-3 fw-semibold shadow-sm" style="background-color: #0284c7;">
                        {{ $alat->exists ? 'Simpan Perubahan' : 'Simpan Alat' }}
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const imgPreview = document.getElementById('imgPreview');
        const placeholder = document.getElementById('placeholderPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .fs-7 { font-size: 13px; }
    .fs-8 { font-size: 11px; }
    .form-control:focus, .form-select:focus {
        background-color: #ffffff !important;
        border-color: #0284c7 !important;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15) !important;
    }
    .hover-primary:hover {
        color: #0284c7 !important;
    }
</style>
@endsection