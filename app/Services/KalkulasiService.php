<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class KalkulasiService
{
    /**
     * Hitung estimasi PKB menggunakan Stored Procedure MySQL.
     *
     * @param  int  $jenisId     ID jenis kendaraan
     * @param  int  $tahun       Tahun kendaraan
     * @param  int  $bulanTelat  Jumlah bulan keterlambatan
     */
    public function hitung(int $jenisId, int $tahun, int $bulanTelat = 0): array
    {
        $tanggal = now()->toDateString();

        $hasil = DB::select(
            'CALL sp_hitung_estimasi(?, ?, ?, ?)',
            [$jenisId, $tahun, $bulanTelat, $tanggal]
        );

        if (empty($hasil)) {
            return [
                'pokok'      => 0,
                'denda'      => 0,
                'potongan'   => 0,
                'total'      => 0,
                'promo'      => null,
                'ditemukan'  => false,
            ];
        }

        $row = (array) $hasil[0];

        return [
            'pokok'     => (float) ($row['pokok'] ?? 0),
            'denda'     => (float) ($row['denda'] ?? 0),
            'potongan'  => (float) ($row['potongan'] ?? 0),
            'total'     => (float) ($row['total'] ?? 0),
            'promo'     => $row['nama_promo'] ?? null,
            'ditemukan' => true,
        ];
    }
}
