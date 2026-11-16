<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasukanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Budi Santoso',
                'kontak' => 'budi.s@email.com',
                'rating' => 5,
                'isi' => 'Pelayanan sangat cepat dan ramah. Terima kasih Samsat Manyar!',
                'status' => 'Selesai',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(8),
            ],
            [
                'nama' => 'Siti Rahayu',
                'kontak' => '081234567890',
                'rating' => 4,
                'isi' => 'Antrian agak lama tapi petugas sangat membantu. Semoga ditambah loket ya.',
                'status' => 'Ditinjau',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(3),
            ],
            [
                'nama' => null,
                'kontak' => null,
                'rating' => 3,
                'isi' => 'Mohon informasi persyaratan di website diperjelas, kadang bingung berkas apa saja yang perlu dibawa.',
                'status' => 'Baru',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'kontak' => 'ahmad.fauzi@email.com',
                'rating' => 5,
                'isi' => 'Kalkulator pajaknya sangat membantu! Jadi bisa mempersiapkan biaya sebelum datang ke Samsat.',
                'status' => 'Baru',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
        ];

        DB::table('masukan')->insert($data);
    }
}
