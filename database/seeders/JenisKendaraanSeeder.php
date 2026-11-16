<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKendaraanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Sepeda Motor', 'kode' => 'MOTOR', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Mobil Penumpang', 'kode' => 'MOBIL_PENUMPANG', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Mobil Beban (Pick Up)', 'kode' => 'PICKUP', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Bus', 'kode' => 'BUS', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Truk', 'kode' => 'TRUK', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('jenis_kendaraan')->insert($data);
    }
}
