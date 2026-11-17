<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Pengaturan;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $fillable = [
        'peminjaman_id',
        'petugas_id',
        'tgl_kembali',
        'denda_kerusakan',
        'catatan',
    ];

    protected $casts = [
        'tgl_kembali' => 'date',
        'denda_kerusakan' => 'float',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(
            Peminjaman::class,
            'peminjaman_id'
        );
    }

    public function petugas()
    {
        return $this->belongsTo(
            User::class,
            'petugas_id'
        );
    }

    /**
     * Jumlah hari keterlambatan.
     */
    public function getHariTerlambatAttribute(): int
    {
        if (!$this->peminjaman?->tgl_harus_kembali) {
            return 0;
        }

        $batasKembali = Carbon::parse(
            $this->peminjaman->tgl_harus_kembali
        );

        $tanggalKembali = Carbon::parse(
            $this->tgl_kembali
        );

        if ($tanggalKembali->lessThanOrEqualTo($batasKembali)) {
            return 0;
        }

        return $batasKembali->diffInDays(
            $tanggalKembali
        );
    }

    /**
     * Denda keterlambatan.
     *
    * Tarif mengikuti pengaturan sistem saat ini.
     */
    public function getDendaAttribute(): float
    {
        $tarifPerHari = (float) Pengaturan::ambil('tarif_denda_harian', 0);

        return $this->hari_terlambat * $tarifPerHari;
    }

    /**
     * Total seluruh denda.
     */
    public function getTotalDendaAttribute(): float
    {
        return $this->denda +
            (float) ($this->denda_kerusakan ?? 0);
    }
}
