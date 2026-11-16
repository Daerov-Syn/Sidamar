<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Pastikan request berasal dari admin yang sudah login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => ['code' => 'UNAUTHENTICATED', 'message' => 'Silakan login terlebih dahulu.'],
                ], 401);
            }

            return redirect()->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
