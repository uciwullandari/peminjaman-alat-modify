<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light border-bottom">
            <tr>
                <th class="ps-4 py-3 text-secondary text-uppercase fs-7 fw-bold" style="width: 60px;">NO</th>
                <th class="py-3 text-secondary text-uppercase fs-7 fw-bold">NAMA</th>
                <th class="py-3 text-secondary text-uppercase fs-7 fw-bold">NAMA PENGGUNA</th>
                <th class="py-3 text-secondary text-uppercase fs-7 fw-bold text-center">PERAN</th>
                <th class="py-3 text-secondary text-uppercase fs-7 fw-bold">TELEPON</th>
                <th class="py-3 text-secondary text-uppercase fs-7 fw-bold text-center">STATUS</th>
                <th class="pe-4 py-3 text-secondary text-uppercase fs-7 fw-bold text-center" style="width: 170px;">AKSI</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($daftarPengguna as $index => $pengguna)
                @php
                    // Ambil peran dari Spatie Permission
                    $namaPeran = $pengguna->roles->first()->name ?? '-';

                    // Pengaturan warna badge Peran
                    $peranLower = strtolower($namaPeran);
                    $bgPeran = '#e0f2fe';
                    $colorPeran = '#0284c7';

                    if (str_contains($peranLower, 'admin')) {
                        $bgPeran = '#e0f2fe';
                        $colorPeran = '#0369a1';
                    } elseif (str_contains($peranLower, 'petugas')) {
                        $bgPeran = '#e0e7ff';
                        $colorPeran = '#4338ca';
                    }
                @endphp
                <tr>
                    {{-- NO --}}
                    <td class="ps-4 py-3 text-secondary fw-medium">
                        {{ method_exists($daftarPengguna, 'firstItem') ? $daftarPengguna->firstItem() + $index : $index + 1 }}
                    </td>

                    {{-- NAMA --}}
                    <td class="fw-bold text-dark fs-6">{{ $pengguna->nama }}</td>

                    {{-- NAMA PENGGUNA --}}
                    <td class="text-secondary fw-medium fs-7">{{ $pengguna->username }}</td>

                    {{-- PERAN --}}
                    <td class="text-center">
                        <span class="badge rounded-pill fw-semibold px-3 py-1.5" style="background-color: {{ $bgPeran }}; color: {{ $colorPeran }}; font-size: 12px; text-transform: capitalize;">
                            {{ $namaPeran }}
                        </span>
                    </td>

                    {{-- TELEPON --}}
                    <td class="text-secondary fs-7 fw-medium">
                        {{ $pengguna->no_telp ?? '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="text-center">
                        @if(! $pengguna->is_disetujui)
                            <span class="badge rounded-pill fw-semibold px-3 py-1.5 d-inline-flex align-items-center gap-1.5" style="background-color: #fef3c7; color: #b45309; font-size: 12px;">
                                <span style="font-size: 10px;">●</span> Menunggu Konfirmasi
                            </span>
                        @elseif($pengguna->is_aktif)
                            <span class="badge rounded-pill fw-semibold px-3 py-1.5 d-inline-flex align-items-center gap-1.5" style="background-color: #dcfce7; color: #15803d; font-size: 12px;">
                                <span style="font-size: 10px;">●</span> Aktif
                            </span>
                        @else
                            <span class="badge rounded-pill fw-semibold px-3 py-1.5 d-inline-flex align-items-center gap-1.5" style="background-color: #f3f4f6; color: #4b5563; font-size: 12px;">
                                <span style="font-size: 10px;">●</span> Nonaktif
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="pe-4 text-center">
                        <div class="d-inline-flex gap-2 justify-content-center align-items-center">
                            @if($pengguna->hasRole('peminjam') && ! $pengguna->is_disetujui)
                                <form action="{{ route('pengguna.setujui', $pengguna) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action-soft btn-approve-soft" title="Konfirmasi Peminjam">
                                        <span>✓</span>
                                        <span>Setujui</span>
                                    </button>
                                </form>
                            @endif

                            {{-- UBAH / EDIT --}}
                            <a href="{{ route('pengguna.edit', $pengguna) }}" 
                               class="btn-action-soft btn-edit-soft text-decoration-none" 
                               title="Ubah Pengguna">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                <span>Edit</span>
                            </a>

                            {{-- HAPUS (SEMBUNYIKAN KHUSUS ADMIN ATAU AKUN SENDIRI) --}}
                            @if(!str_contains(strtolower($namaPeran), 'admin') && $pengguna->id !== auth()->id())
                                <form action="{{ route('pengguna.destroy', $pengguna) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna {{ $pengguna->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-soft btn-delete-soft" title="Hapus Pengguna">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">Data pengguna tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .fs-7 { font-size: 13px; }
    .table > :not(caption) > * > * { padding: 0.9rem 0.85rem; }

    .btn-action-soft {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 20px;
        border: none;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .btn-edit-soft {
        background-color: #fef3c7;
        color: #b45309;
    }
    .btn-edit-soft:hover {
        background-color: #fde047;
        color: #854d0e;
        transform: translateY(-1px);
    }

    .btn-delete-soft {
        background-color: #ffe4e6;
        color: #e11d48;
    }
    .btn-delete-soft:hover {
        background-color: #f87171;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-approve-soft {
        background-color: #dcfce7;
        color: #15803d;
    }
    .btn-approve-soft:hover {
        background-color: #86efac;
        color: #166534;
        transform: translateY(-1px);
    }
</style>