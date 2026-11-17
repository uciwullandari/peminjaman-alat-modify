<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    // Gunakan created_at saja, matikan updated_at
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'aksi',
        'tabel_tujuan',
        'deskripsi',
        'ip_address',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
