<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\KalkulasiRequest;
use App\Services\KalkulasiService;

class KalkulasiController extends Controller
{
    public function __construct(private KalkulasiService $kalkulasiService) {}

    public function hitung(KalkulasiRequest $request)
    {
        $hasil = $this->kalkulasiService->hitung(
            jenisId: (int) $request->input('jenis_id'),
            tahun:   (int) $request->input('tahun'),
            bulanTelat: (int) $request->input('bulan_telat', 0),
        );

        return response()->json([
            'data' => array_merge($hasil, [
                'catatan' => 'Hasil ini adalah ESTIMASI dan bukan tagihan resmi. Harap konfirmasi ke petugas Samsat Manyar.',
            ]),
        ]);
    }
}
