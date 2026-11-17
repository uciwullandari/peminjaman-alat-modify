<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'no_telp',
        'is_aktif',
        'is_disetujui',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_aktif' => 'boolean',
            'is_disetujui' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi peminjaman yang diajukan oleh user.
     */
    public function peminjamanDiajukan()
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    /**
     * Relasi log aktivitas user.
     */
    public function daftarLog()
    {
        return $this->hasMany(LogAktivitas::class, 'user_id');
    }
}
