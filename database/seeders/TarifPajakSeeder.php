<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TarifPajakSeeder extends Seeder
{
    /**
     * CONTOH - verifikasi dengan Pergub/Perda
     * Data tarif ini hanya contoh untuk pengembangan.
     */
    public function run(): void
    {
        $jenis = DB::table('jenis_kendaraan')->pluck('id', 'kode');

        $data = [
            // Motor
            ['jenis_id' => $jenis['MOTOR'], 'tahun_min' => 2020, 'tahun_max' => 2026, 'nilai_dasar' => 15000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['MOTOR'], 'tahun_min' => 2015, 'tahun_max' => 2019, 'nilai_dasar' => 10000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['MOTOR'], 'tahun_min' => 2010, 'tahun_max' => 2014, 'nilai_dasar' => 7000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['MOTOR'], 'tahun_min' => 2000, 'tahun_max' => 2009, 'nilai_dasar' => 4000000, 'tarif_persen' => 1.50],
            // Mobil Penumpang
            ['jenis_id' => $jenis['MOBIL_PENUMPANG'], 'tahun_min' => 2020, 'tahun_max' => 2026, 'nilai_dasar' => 200000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['MOBIL_PENUMPANG'], 'tahun_min' => 2015, 'tahun_max' => 2019, 'nilai_dasar' => 150000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['MOBIL_PENUMPANG'], 'tahun_min' => 2010, 'tahun_max' => 2014, 'nilai_dasar' => 100000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['MOBIL_PENUMPANG'], 'tahun_min' => 2000, 'tahun_max' => 2009, 'nilai_dasar' => 60000000, 'tarif_persen' => 1.50],
            // Pick Up
            ['jenis_id' => $jenis['PICKUP'], 'tahun_min' => 2020, 'tahun_max' => 2026, 'nilai_dasar' => 180000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['PICKUP'], 'tahun_min' => 2015, 'tahun_max' => 2019, 'nilai_dasar' => 130000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['PICKUP'], 'tahun_min' => 2010, 'tahun_max' => 2014, 'nilai_dasar' => 90000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['PICKUP'], 'tahun_min' => 2000, 'tahun_max' => 2009, 'nilai_dasar' => 50000000, 'tarif_persen' => 1.50],
            // Bus
            ['jenis_id' => $jenis['BUS'], 'tahun_min' => 2020, 'tahun_max' => 2026, 'nilai_dasar' => 350000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['BUS'], 'tahun_min' => 2015, 'tahun_max' => 2019, 'nilai_dasar' => 250000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['BUS'], 'tahun_min' => 2010, 'tahun_max' => 2014, 'nilai_dasar' => 180000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['BUS'], 'tahun_min' => 2000, 'tahun_max' => 2009, 'nilai_dasar' => 100000000, 'tarif_persen' => 1.50],
            // Truk
            ['jenis_id' => $jenis['TRUK'], 'tahun_min' => 2020, 'tahun_max' => 2026, 'nilai_dasar' => 300000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['TRUK'], 'tahun_min' => 2015, 'tahun_max' => 2019, 'nilai_dasar' => 220000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['TRUK'], 'tahun_min' => 2010, 'tahun_max' => 2014, 'nilai_dasar' => 160000000, 'tarif_persen' => 1.50],
            ['jenis_id' => $jenis['TRUK'], 'tahun_min' => 2000, 'tahun_max' => 2009, 'nilai_dasar' => 90000000, 'tarif_persen' => 1.50],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
        }

        DB::table('tarif_pajak')->insert($data);
    }
}
