<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarPengaturan = [
            ['kunci' => 'tarif_denda_harian',  'nilai' => '5000'],
            ['kunci' => 'default_hari_pinjam', 'nilai' => '7'],
            ['kunci' => 'maks_hari_pinjam',    'nilai' => '30'],
            ['kunci' => 'nama_sekolah',        'nilai' => 'SMK Negeri 1 Contoh']
        ];

        foreach ($daftarPengaturan as $data) {
           Pengaturan::firstOrCreate(
                ['kunci' => $data['kunci']],
                ['nilai' => $data['nilai']]
            );
        }
    }
}
