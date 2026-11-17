<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PersetujuanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LogAktivitasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KoreksiPeminjamanController;
use App\Http\Controllers\KoreksiPengembalianController;
use App\Http\Controllers\PengaturanController;
use App\Enums\StatusPeminjaman;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Kategori;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        $pengguna = auth()->user();

        // Admin
        if ($pengguna->hasRole('admin')) {
            return redirect()->route('admin.dasbor');
        }

        // Petugas
        if ($pengguna->hasRole('petugas')) {
            return redirect()->route('petugas.dasbor');
        }

        // Peminjam
        return redirect()->route('peminjam.dasbor');
    }

    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| ROUTE YANG MEMBUTUHKAN LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASBOR
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dasbor', function () {
        $mulaiGrafik = now()->startOfMonth()->subMonths(5);
        $bulanGrafik = collect(range(0, 5))->mapWithKeys(function (int $urutan) use ($mulaiGrafik) {
            $bulan = $mulaiGrafik->copy()->addMonths($urutan);

            return [$bulan->format('Y-m') => [
                'label' => $bulan->translatedFormat('M Y'),
                'diajukan' => 0,
                'dipinjam' => 0,
                'menunggu_verifikasi' => 0,
                'selesai' => 0,
                'ditolak' => 0,
            ]];
        });

        Peminjaman::where('created_at', '>=', $mulaiGrafik)
            ->get(['created_at', 'status'])
            ->each(function (Peminjaman $peminjaman) use ($bulanGrafik): void {
                $kunciBulan = $peminjaman->created_at->format('Y-m');
                $status = $peminjaman->status->value;

                if ($bulanGrafik->has($kunciBulan)) {
                    $dataBulan = $bulanGrafik->get($kunciBulan);

                    if (array_key_exists($status, $dataBulan)) {
                        $dataBulan[$status]++;
                        $bulanGrafik->put($kunciBulan, $dataBulan);
                    }
                }
            });

        return view('dasbor.admin', [
            'totalAlat' => Alat::count(),
            'totalDipinjam' => Peminjaman::where('status', StatusPeminjaman::Dipinjam)->count(),
            'totalPengguna' => User::count(),
            'totalKategori' => Kategori::count(),
            'totalMenungguPersetujuan' => Peminjaman::where('status', StatusPeminjaman::Diajukan)->count(),
            'registrasiPeminjamanTerbaru' => Peminjaman::with(['peminjam', 'detail'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
            'peminjamanTerlambat' => Peminjaman::with(['peminjam', 'detail'])
                ->whereIn('status', [
                    StatusPeminjaman::Dipinjam,
                    StatusPeminjaman::MenungguVerifikasi,
                ])
                ->whereDate('tgl_harus_kembali', '<', today())
                ->orderBy('tgl_harus_kembali')
                ->get(),
            'grafikPeminjaman' => $bulanGrafik->values(),
        ]);
    })->middleware('role:admin')->name('admin.dasbor');

    Route::get('/petugas/dasbor', function () {
        $registrasiPeminjamanMenunggu = Peminjaman::with(['peminjam', 'detail'])
            ->where('status', StatusPeminjaman::Diajukan)
            ->orderBy('created_at')
            ->get();

        $peminjamanTerlambat = Peminjaman::with(['peminjam', 'detail'])
            ->whereIn('status', [
                StatusPeminjaman::Dipinjam,
                StatusPeminjaman::MenungguVerifikasi,
            ])
            ->whereDate('tgl_harus_kembali', '<', today())
            ->orderBy('tgl_harus_kembali')
            ->get();

        return view('dasbor.petugas', [
            'totalPersetujuan' => $registrasiPeminjamanMenunggu->count(),
            'registrasiPeminjamanMenunggu' => $registrasiPeminjamanMenunggu,
            'peminjamanTerlambat' => $peminjamanTerlambat,
        ]);
    })->middleware('role:petugas')->name('petugas.dasbor');

    Route::get('/peminjam/dasbor', function () {
        $peminjamanSaya = Peminjaman::where('user_id', auth()->id());

        return view('dasbor.peminjam', [
            'totalPengajuan' => (clone $peminjamanSaya)->where('status', StatusPeminjaman::Diajukan)->count(),
            'totalDipinjam' => (clone $peminjamanSaya)->where('status', StatusPeminjaman::Dipinjam)->count(),
            'totalMenungguPengembalian' => (clone $peminjamanSaya)->where('status', StatusPeminjaman::MenungguVerifikasi)->count(),
            'totalSelesai' => (clone $peminjamanSaya)->where('status', StatusPeminjaman::Selesai)->count(),
        ]);
    })->middleware('role:peminjam')->name('peminjam.dasbor');

    /*
    |--------------------------------------------------------------------------
    | KATEGORI
    |--------------------------------------------------------------------------
    */

    Route::resource('kategori', KategoriController::class)
        ->middleware('permission:kategori.kelola');

    /*
    |--------------------------------------------------------------------------
    | ALAT
    |--------------------------------------------------------------------------
    */

    Route::resource('alat', AlatController::class)
        ->except(['show'])
        ->middleware('permission:alat.kelola');

    /*
    |--------------------------------------------------------------------------
    | PENGGUNA
    |--------------------------------------------------------------------------
    */

    Route::resource('pengguna', PenggunaController::class)
        ->except(['show'])
        ->middleware('permission:user.kelola');

    Route::patch('/pengguna/{pengguna}/setujui', [PenggunaController::class, 'setujui'])
        ->middleware('permission:user.kelola')
        ->name('pengguna.setujui');

    /*
    |--------------------------------------------------------------------------
    | KATALOG & KERANJANG
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:alat.lihat')
        ->prefix('katalog')
        ->name('katalog.')
        ->group(function () {
            Route::get('/', [KatalogController::class, 'katalog'])->name('daftar');
            Route::get('/keranjang', [KatalogController::class, 'lihatKeranjang'])->name('keranjang');
            Route::post('/{alat}/tambah', [KatalogController::class, 'tambahKeKeranjang'])->name('tambah');
            Route::put('/{alat}/jumlah', [KatalogController::class, 'ubahJumlah'])->name('ubah-jumlah');
            Route::delete('/{alatId}/hapus', [KatalogController::class, 'hapusDariKeranjang'])->name('hapus');
            Route::delete('/kosongkan', [KatalogController::class, 'kosongkanKeranjang'])->name('kosongkan');
        });

    /*
    |--------------------------------------------------------------------------
    | PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:peminjaman.ajukan')
        ->prefix('peminjaman')
        ->name('peminjaman.')
        ->group(function () {
            Route::get('/ajukan', [PeminjamanController::class, 'formPengajuan'])->name('ajukan');
            Route::post('/ajukan', [PeminjamanController::class, 'simpanPengajuan'])->name('simpan');
            Route::get('/saya', [PeminjamanController::class, 'daftarSaya'])->name('saya');
            Route::get('/{peminjaman}', [PeminjamanController::class, 'rinci'])->name('rincian');
        });

    /*
    |--------------------------------------------------------------------------
    | PERSETUJUAN PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:peminjaman.setujui')
        ->prefix('persetujuan')
        ->name('persetujuan.')
        ->group(function () {
            Route::get('/', [PersetujuanController::class, 'antrian'])->name('antrian');
            Route::get('/{peminjaman}', [PersetujuanController::class, 'rincian'])->name('rincian');
            Route::post('/{peminjaman}/setujui', [PersetujuanController::class, 'setujui'])->name('setujui');
            Route::post('/{peminjaman}/tolak', [PersetujuanController::class, 'tolak'])->name('tolak');
        });

    /*
    |--------------------------------------------------------------------------
    | PEMANTAUAN PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:peminjaman.setujui')
        ->prefix('pemantauan')
        ->name('pemantauan.')
        ->group(function () {
            Route::get('/', [PersetujuanController::class, 'pemantauan'])->name('index');
            Route::get('/{peminjaman}', [PersetujuanController::class, 'pemantauanRincian'])->name('rincian');
        });

    /*
    |--------------------------------------------------------------------------
    | PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:peminjaman.kembalikan')
        ->post('/peminjaman/{peminjaman}/kembalikan', [PengembalianController::class, 'ajukan'])
        ->name('pengembalian.ajukan');

    /*
    |--------------------------------------------------------------------------
    | PANTAU & VERIFIKASI PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:pengembalian.pantau')
        ->prefix('pengembalian')
        ->name('pengembalian.')
        ->group(function () {
            Route::get('/pantau', [PengembalianController::class, 'pantau'])->name('pantau');
            Route::get('/antrian', [PengembalianController::class, 'antrian'])->name('antrian');
            Route::get('/{peminjaman}/verifikasi', [PengembalianController::class, 'formVerifikasi'])->name('verifikasi');
            Route::post('/{peminjaman}/verifikasi', [PengembalianController::class, 'simpanVerifikasi'])->name('simpan');
            Route::get('/rincian/{pengembalian}', [PengembalianController::class, 'rincian'])->name('rincian');
        });

    /*
    |--------------------------------------------------------------------------
    | KOREKSI PEMINJAMAN & PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    Route::prefix('koreksi/peminjaman')
        ->name('koreksi.peminjaman.')
        ->group(function () {
            Route::get('/', [KoreksiPeminjamanController::class, 'daftar'])->name('daftar');
            Route::get('/{peminjaman}/ubah', [KoreksiPeminjamanController::class, 'formUbah'])->name('ubah');
            Route::put('/{peminjaman}', [KoreksiPeminjamanController::class, 'perbarui'])->name('perbarui');
            Route::delete('/{peminjaman}', [KoreksiPeminjamanController::class, 'hapus'])->name('hapus');
        });

    Route::prefix('koreksi/pengembalian')
        ->name('koreksi.pengembalian.')
        ->group(function () {
            Route::get('/', [KoreksiPengembalianController::class, 'daftar'])->name('daftar');
            Route::get('/{pengembalian}/ubah', [KoreksiPengembalianController::class, 'formUbah'])->name('ubah');
            Route::put('/{pengembalian}', [KoreksiPengembalianController::class, 'perbarui'])->name('perbarui');
        });

    /*
    |--------------------------------------------------------------------------
    | LOG AKTIVITAS & LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:log.lihat')
        ->prefix('log-aktivitas')
        ->name('log.')
        ->group(function () {
            Route::get('/', [LogAktivitasController::class, 'index'])->name('index');
        });

    Route::middleware('permission:laporan.cetak')
        ->prefix('laporan')
        ->name('laporan.')
        ->group(function () {
            Route::get('/', [LaporanController::class, 'form'])->name('form');
            Route::get('/peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman');
            Route::get('/pengembalian', [LaporanController::class, 'pengembalian'])->name('pengembalian');
            Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
        });

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:pengaturan.kelola')
        ->prefix('pengaturan')
        ->name('pengaturan.')
        ->group(function () {
            Route::get('/', [PengaturanController::class, 'form'])->name('form');
            Route::put('/', [PengaturanController::class, 'perbarui'])->name('perbarui');
        });

});
