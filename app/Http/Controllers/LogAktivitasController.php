<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $aksi = $request->query('aksi');
        $tglAwal = $request->query('tgl_awal');
        $tglAkhir = $request->query('tgl_akhir');

        // Query logs dengan filter
        $afterLog = LogAktivitas::query()
            ->with('pengguna')
            ->when($userId, function ($query, $userId) {
                $query->where('user_id', $userId);
            })
            ->when($aksi, function ($query, $aksi) {
                $query->where('aksi', $aksi);
            })
            ->when($tglAwal, function ($query, $tglAwal) {
                $query->whereDate('created_at', '>=', $tglAwal);
            })
            ->when($tglAkhir, function ($query, $tglAkhir) {
                $query->whereDate('created_at', '<=', $tglAkhir);
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        // Ambil daftar pengguna yang memiliki log
        $daftarPengguna = User::whereHas('daftarLog')
            ->orderBy('nama')
            ->get();

        // Ambil daftar aksi unik dari log
        $daftarAksi = LogAktivitas::distinct()
            ->pluck('aksi')
            ->sort()
            ->values();

        return view('log.daftar', [
            'afterLog' => $afterLog,
            'logs' => $afterLog,
            'daftarLog' => $afterLog->items(),
            'daftarPengguna' => $daftarPengguna,
            'daftarAksi' => $daftarAksi,
            'userId' => $userId,
            'aksi' => $aksi,
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
        ]);
    }
}
