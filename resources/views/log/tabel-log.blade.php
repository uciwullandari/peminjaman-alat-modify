<div class="table-responsive">
    <table class="table table-hover align-middle mb-0 border-top">
        <thead class="bg-light">
            <tr>
                <th class="py-3 px-3 text-muted fw-semibold fs-7 border-0" style="width: 160px;">Waktu</th>
                <th class="py-3 px-3 text-muted fw-semibold fs-7 border-0" style="width: 200px;">Pengguna</th>
                <th class="py-3 px-3 text-muted fw-semibold fs-7 border-0" style="width: 130px;">Aksi</th>
                <th class="py-3 px-3 text-muted fw-semibold fs-7 border-0">Deskripsi</th>
                <th class="py-3 px-3 text-muted fw-semibold fs-7 border-0 text-end" style="width: 130px;">Alamat IP</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs ?? $activityLogs ?? [] as $log)
                <tr>
                    {{-- WAKTU --}}
                    <td class="px-3 py-3 fs-7 text-secondary">
                        {{ \Carbon\Carbon::parse($log->created_at ?? $log->waktu)->format('d/m/Y H:i') }}
                    </td>

                    {{-- PENGGUNA --}}
                    <td class="px-3 py-3 fs-7 fw-semibold text-dark">
                        {{ $log->pengguna?->nama ?? 'Tidak dikenal' }}
                    </td>

                    {{-- AKSI --}}
                    <td class="px-3 py-3">
                        @php
                            $aksiText = strtolower($log->aksi ?? $log->description ?? '');
                            $badgeClass = match(true) {
                                str_contains($aksiText, 'create') || str_contains($aksiText, 'tambah') => 'bg-success-subtle text-success border-success-subtle',
                                str_contains($aksiText, 'update') || str_contains($aksiText, 'ubah') => 'bg-info-subtle text-info border-info-subtle',
                                str_contains($aksiText, 'delete') || str_contains($aksiText, 'hapus') => 'bg-danger-subtle text-danger border-danger-subtle',
                                str_contains($aksiText, 'login') => 'bg-primary-subtle text-primary border-primary-subtle',
                                str_contains($aksiText, 'logout') => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                                default => 'bg-dark-subtle text-dark border-dark-subtle'
                            };
                        @endphp
                        <span class="badge border px-2.5 py-1 rounded-pill fw-medium fs-8 {{ $badgeClass }}">
                            {{ $log->aksi ?? $log->description }}
                        </span>
                    </td>

                    {{-- DESKRIPSI --}}
                    <td class="px-3 py-3 fs-7 text-dark">
                        {{ $log->deskripsi ?? $log->keterangan ?? '-' }}
                    </td>

                    {{-- ALAMAT IP --}}
                    <td class="px-3 py-3 fs-7 text-muted text-end font-monospace">
                        {{ $log->ip_address ?? $log->ip ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <p class="mb-0 fs-7">Belum ada riwayat log aktivitas yang tercatat.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if (isset($logs) && method_exists($logs, 'hasPages') && $logs->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $logs->links() }}
    </div>
@endif

<style>
    .fs-7 { font-size: 13.5px; }
    .fs-8 { font-size: 11.5px; }

    .pagination {
        gap: 4px;
        margin-left: 12px;
    }

    .pagination .page-item .page-link {
        border-radius: 6px;
    }
</style>