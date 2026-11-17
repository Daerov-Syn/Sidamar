<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\BerandaController;
use App\Http\Controllers\Public\LayananController;
use App\Http\Controllers\Public\MasukanController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\OtpController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LayananController as AdminLayananController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\MasukanController as AdminMasukanController;
use App\Http\Controllers\Admin\PenggunaController;

/*
|--------------------------------------------------------------------------
| Portal Publik
|--------------------------------------------------------------------------
*/

Route::get('/deploy-setup', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $mig = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $seed = \Illuminate\Support\Facades\Artisan::output();

        return response("<h2>Setup Database Sukses!</h2><pre>$mig\n$seed</pre><br><a href='/'>Buka Beranda SiDamar</a>");
    } catch (\Throwable $e) {
        return response("<h2>Setup Error:</h2><pre>" . $e->getMessage() . "\n\n" . $e->getTraceAsString() . "</pre>", 500);
    }
});

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/', [LayananController::class, 'index'])->name('index');
    Route::get('/{slug}', [LayananController::class, 'show'])->name('show');
});

Route::prefix('masukan')->name('masukan.')->group(function () {
    Route::get('/buat', [MasukanController::class, 'create'])->name('create');
    Route::post('/', [MasukanController::class, 'store'])
        ->middleware('throttle:masukan')
        ->name('store');
});

/*
|--------------------------------------------------------------------------
| Panel Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth (tidak butuh login)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:admin-login')
        ->name('login.post');
    Route::get('/otp', [OtpController::class, 'showOtp'])->name('otp');
    Route::post('/otp', [OtpController::class, 'verify'])
        ->middleware('throttle:admin-otp')
        ->name('otp.verify');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Area terproteksi
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kelola Layanan
        Route::resource('layanan', AdminLayananController::class)
            ->names('layanan')
            ->parameters(['layanan' => 'layanan']);

        // Kelola Pengguna
        Route::resource('pengguna', PenggunaController::class)
            ->names('pengguna')
            ->parameters(['pengguna' => 'admin']);

        // Tarif, Denda, Promo
        Route::get('/tarif', [TarifController::class, 'index'])->name('tarif.index');
        Route::post('/tarif', [TarifController::class, 'store'])->name('tarif.store');
        Route::put('/tarif/{tarif}', [TarifController::class, 'update'])->name('tarif.update');
        Route::delete('/tarif/{tarif}', [TarifController::class, 'destroy'])->name('tarif.destroy');

        Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
        Route::post('/denda', [DendaController::class, 'store'])->name('denda.store');
        Route::put('/denda/{denda}', [DendaController::class, 'update'])->name('denda.update');
        Route::delete('/denda/{denda}', [DendaController::class, 'destroy'])->name('denda.destroy');

        Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');
        Route::post('/promo', [PromoController::class, 'store'])->name('promo.store');
        Route::put('/promo/{promo}', [PromoController::class, 'update'])->name('promo.update');
        Route::delete('/promo/{promo}', [PromoController::class, 'destroy'])->name('promo.destroy');

        // Data Masukan
        Route::get('/masukan', [AdminMasukanController::class, 'index'])->name('masukan.index');
        Route::patch('/masukan/{masukan}/status', [AdminMasukanController::class, 'updateStatus'])
            ->name('masukan.update-status');
    });
});
