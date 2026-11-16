<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AturanDendaSeeder extends Seeder
{
    /**
     * CONTOH - verifikasi dengan Pergub/Perda
     * Aturan denda ini hanya contoh untuk pengembangan.
     */
    public function run(): void
    {
        $data = [
            ['periode_min_bulan' => 1, 'periode_max_bulan' => 3, 'tipe' => 'persen', 'nilai' => 25.00],
            ['periode_min_bulan' => 4, 'periode_max_bulan' => 6, 'tipe' => 'persen', 'nilai' => 50.00],
            ['periode_min_bulan' => 7, 'periode_max_bulan' => 12, 'tipe' => 'persen', 'nilai' => 75.00],
            ['periode_min_bulan' => 13, 'periode_max_bulan' => 24, 'tipe' => 'persen', 'nilai' => 100.00],
            ['periode_min_bulan' => 25, 'periode_max_bulan' => 9999, 'tipe' => 'persen', 'nilai' => 100.00],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
        }

        DB::table('aturan_denda')->insert($data);
    }
}
