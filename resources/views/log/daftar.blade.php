@extends('layouts.utama')

@section('judul', 'Log Aktivitas')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">
        Log Aktivitas
    </h4>
</div>

<div class="card">
    <div class="card-body">

        @include('log.form-search')

        <div class="table-responsive">
            @include('log.tabel-log')
        </div>

        {{-- Pagination --}}
        @if ($daftarLog instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $daftarLog->links() }}
        @endif

    </div>
</div>

@endsection
