<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    public function showLogin()
    {
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $admin = Admin::where('username', $request->input('username'))->first();

        if (! $admin || ! Hash::check($request->input('password'), $admin->password)) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Username atau password salah.']);
        }

        // Kirim OTP
        $this->otpService->kirimOtp($admin);

        // Simpan admin_id di session sementara (belum login penuh)
        session(['otp_admin_id' => $admin->id]);

        return redirect()->route('admin.otp');
    }

    public function logout(Request $request)
    {
        auth('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
