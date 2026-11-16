<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\KalkulasiController;
use App\Http\Controllers\Api\V1\JenisKendaraanController;
use App\Http\Controllers\Api\V1\PromoController;
use App\Http\Controllers\Api\V1\LayananController;
use App\Http\Controllers\Api\V1\MasukanController;

/*
|--------------------------------------------------------------------------
| API Routes - Versi 1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->name('api.v1.')->group(function () {

    // Kalkulasi estimasi PKB
    Route::post('/kalkulasi', [KalkulasiController::class, 'hitung'])
        ->middleware('throttle:kalkulasi')
        ->name('kalkulasi');

    // Referensi data
    Route::get('/jenis-kendaraan', [JenisKendaraanController::class, 'index'])
        ->name('jenis-kendaraan');

    Route::get('/promo-aktif', [PromoController::class, 'index'])
        ->name('promo-aktif');

    // Layanan
    Route::get('/layanan', [LayananController::class, 'index'])
        ->name('layanan.index');
    Route::get('/layanan/{slug}', [LayananController::class, 'show'])
        ->name('layanan.show');

    // Masukan publik
    Route::post('/masukan', [MasukanController::class, 'store'])
        ->middleware('throttle:masukan-api')
        ->name('masukan.store');
});
