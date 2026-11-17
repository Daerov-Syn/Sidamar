<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function migrateServiceTables(): void
    {
        $this->artisan('migrate', [
            '--path' => [
                'database/migrations/2024_01_01_000004_create_promo_pemutihan_table.php',
                'database/migrations/2024_01_01_000005_create_kategori_layanan_table.php',
                'database/migrations/2024_01_01_000006_create_layanan_table.php',
                'database/migrations/2024_01_01_000007_create_layanan_berkas_table.php',
                'database/migrations/2024_01_01_000008_create_layanan_langkah_table.php',
                'database/migrations/2026_11_06_100000_add_fields_to_layanan_berkas_and_langkah.php',
            ],
        ])->assertExitCode(0);
    }
}
