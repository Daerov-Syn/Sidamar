<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            JenisKendaraanSeeder::class,
            TarifPajakSeeder::class,
            AturanDendaSeeder::class,
            PromoPemutihanSeeder::class,
            LayananSeeder::class,
            MasukanSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
