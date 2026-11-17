@extends('layouts.utama')

@section('judul', 'Ajukan Peminjaman')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="loan-page">
    <div class="mb-4">
        <span class="text-primary fw-bold small text-uppercase">Langkah terakhir</span>
        <h2 class="fw-bold mb-1">Ajukan Peminjaman</h2>
        <p class="text-muted mb-0">Lengkapi data berikut untuk mengirim pengajuan alat.</p>
    </div>

    @if ($daftarTunggakan->isNotEmpty())
        <div class="alert alert-danger border-0 shadow-sm">
            <strong><i class="bi bi-exclamation-triangle me-1"></i> Pengajuan tidak dapat dikirim.</strong><br>
            Anda masih memiliki peminjaman yang lewat tenggat:

            <ul class="mb-0 mt-2">
                @foreach ($daftarTunggakan as $tunggakan)
                    <li>
                        {{ $tunggakan->kode_pinjam }}
                        — jatuh tempo
                        {{ $tunggakan->tgl_harus_kembali->format('d/m/Y') }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            @include('peminjaman.alat-diajukan')
        </div>

        <div class="col-lg-5">
            @include('peminjaman.data-peminjam')
        </div>
    </div>
</div>
@endsection