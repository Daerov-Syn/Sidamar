<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\Admin;
use App\Services\OtpService;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    public function showOtp(Request $request)
    {
        if (! $request->session()->has('otp_admin_id')) {
            return redirect()->route('admin.login');
        }
        return view('admin.auth.otp');
    }

    public function verify(VerifyOtpRequest $request)
    {
        $adminId = $request->session()->get('otp_admin_id');

        if (! $adminId) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::find($adminId);
        if (! $admin) {
            return redirect()->route('admin.login');
        }

        $result = $this->otpService->verifikasiOtp($admin, $request->input('kode'));

        if (! $result['valid']) {
            return back()->withErrors(['kode' => $result['pesan']]);
        }

        // Login penuh
        auth('admin')->login($admin);
        $request->session()->forget('otp_admin_id');
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }
}
