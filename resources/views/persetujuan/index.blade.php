@extends('layouts.utama')

@section('judul', 'Antrian Persetujuan Peminjaman')

@section('konten')
<div class="row justify-content-center">
    <div class="col-md-12">
        <!-- Judul Halaman Tanpa Kotak Biru (Sesuai Foto Pertama) -->
        <h4 class="mb-3">Antrian Pengajuan</h4>

        <div class="card shadow-sm">
            <div class="card-body">
                @if(session('sukses'))
                    <div class="alert alert-success">
                        {{ session('sukses') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pinjam</th>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tenggat Kembali</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $index => $peminjaman)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $peminjaman->kode_pinjam }}</td>
                                    <td>{{ $peminjaman->peminjam->name ?? '-' }}</td>
                                    <td>{{ $peminjaman->tgl_pinjam }}</td>
                                    <td>{{ $peminjaman->tgl_harus_kembali }}</td>
                                    <td>
                                        <!-- Form untuk menyetujui peminjaman -->
                                        <form action="{{ route('persetujuan.setujui', $peminjaman->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="tgl_harus_kembali" value="{{ $peminjaman->tgl_harus_kembali }}">
                                            <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada pengajuan yang menunggu diproses.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $peminjamans->links() ?? '' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
