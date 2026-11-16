<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->ensureViteHotFileIsValid();
        $this->configureRateLimiting();
    }

    /**
     * Pastikan file public/hot tidak merusak tampilan saat Vite dev server tidak berjalan.
     * Jika file public/hot ada tetapi server Vite mati, hapus file tersebut secara otomatis.
     */
    protected function ensureViteHotFileIsValid(): void
    {
        $hotFile = public_path('hot');
        if (file_exists($hotFile)) {
            $url = trim((string) file_get_contents($hotFile));
            $parts = parse_url($url);
            $host = $parts['host'] ?? '127.0.0.1';
            if ($host === '[::1]' || $host === '::1' || $host === 'localhost') {
                $host = '127.0.0.1';
            }
            $port = (int) ($parts['port'] ?? 5173);
            $connection = @fsockopen($host, $port, $errno, $errstr, 0.05);

            if (is_resource($connection)) {
                fclose($connection);
            } else {
                @unlink($hotFile);
            }
        }
    }

    protected function configureRateLimiting(): void
    {
        // Kalkulasi: 20 per menit per IP
        RateLimiter::for('kalkulasi', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip())->response(function () {
                return response()->json([
                    'error' => [
                        'code'    => 'RATE_LIMIT',
                        'message' => 'Terlalu banyak permintaan. Coba lagi sebentar.',
                    ],
                ], 429);
            });
        });

        // Masukan web: 3 per jam per IP
        RateLimiter::for('masukan', function (Request $request) {
            return Limit::perHour(3)->by($request->ip());
        });

        // Masukan API: 3 per jam per IP
        RateLimiter::for('masukan-api', function (Request $request) {
            return Limit::perHour(3)->by($request->ip())->response(function () {
                return response()->json([
                    'error' => [
                        'code'    => 'RATE_LIMIT',
                        'message' => 'Terlalu banyak masukan. Coba lagi dalam 1 jam.',
                    ],
                ], 429)->withHeaders(['Retry-After' => 3600]);
            });
        });

        // Admin login: 10 per menit per IP
        RateLimiter::for('admin-login', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        // Admin OTP: 5 per menit per IP
        RateLimiter::for('admin-otp', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
