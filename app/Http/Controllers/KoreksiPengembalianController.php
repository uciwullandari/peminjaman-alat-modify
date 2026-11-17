<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;

class KoreksiPengembalianController extends Controller
{
    /**
     * Menampilkan daftar data pengembalian untuk dikoreksi.
     */
    public function daftar()
    {
        $pengembalians = Pengembalian::with([
            'peminjaman.peminjam',
            'peminjaman.detail.alat',
        ])->latest()->get();

        return view('koreksi.pengembalian-daftar', compact('pengembalians'));
    }

    /**
     * Menampilkan form ubah data pengembalian.
     */
    public function formUbah(Pengembalian $pengembalian)
    {
        return view('koreksi.pengembalian-form', compact('pengembalian'));
    }

    /**
     * Memperbarui data pengembalian.
     */
    public function perbarui(Request $request, Pengembalian $pengembalian)
    {
        $request->validate([
            'denda_kerusakan' => 'required|numeric|min:0',
            'catatan'         => 'nullable|string',
        ]);

        $pengembalian->update([
            'denda_kerusakan' => $request->denda_kerusakan,
            'catatan'         => $request->catatan,
            'total_denda'     => $pengembalian->denda_keterlambatan + $request->denda_kerusakan,
        ]);

        return redirect()->route('koreksi.pengembalian.daftar')
                         ->with('sukses', 'Data pengembalian berhasil dikoreksi.');
    }
}
