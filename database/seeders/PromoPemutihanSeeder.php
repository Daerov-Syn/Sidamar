<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoPemutihanSeeder extends Seeder
{
    /**
     * CONTOH - verifikasi dengan Pergub/Perda
     * Data promo ini hanya contoh untuk pengembangan.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Pemutihan Pajak Kendaraan 2026 - Bebas Denda',
                'mulai' => '2026-10-01',
                'selesai' => '2026-12-31',
                'tipe_potongan' => 'persen',
                'nilai' => 100.00, // 100% free denda
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Diskon PKB HUT Jawa Timur',
                'mulai' => '2026-11-01',
                'selesai' => '2026-11-30',
                'tipe_potongan' => 'persen',
                'nilai' => 10.00, // 10% diskon pokok
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('promo_pemutihan')->insert($data);
    }
}
