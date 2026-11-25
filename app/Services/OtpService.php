<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\Admin;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public const EXPIRY_MINUTES = 5;
    public const MAX_ATTEMPTS   = 5;

    /**
     * Buat OTP, simpan sebagai hash, dan kirim via email.
     * Catatan: kode OTP tidak disimpan dalam plaintext.
     */
    public function kirimOtp(Admin $admin): void
    {
        // Hapus OTP lama milik admin ini
        Otp::where('admin_id', $admin->id)->delete();

        // Generate 6 digit OTP
        $kode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Otp::create([
            'admin_id'   => $admin->id,
            'kode'       => $kode,
            'kode_hash'  => Hash::make($kode),
            'expires_at' => now()->addMinutes(self::EXPIRY_MINUTES),
            'attempts'   => 0,
        ]);

        // Kirim email (pastikan MAIL_ config sudah diisi di .env)
        if (config('mail.default') === 'log' || (config('mail.default') === 'smtp' && empty(config('mail.mailers.smtp.password')))) {
            session()->flash('dev_otp_code', $kode);
            return;
        }

        try {
            Mail::to($admin->email)->send(new OtpMail($kode, $admin->username));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email OTP: ' . $e->getMessage());

            // Fallback: tampilkan kode OTP di halaman agar admin tetap bisa login
            session()->flash('dev_otp_code', $kode);
            session()->flash('otp_mail_error', $e->getMessage());
        }
    }

    /**
     * Verifikasi kode OTP yang dimasukkan admin.
     */
    public function verifikasiOtp(Admin $admin, string $kode): array
    {
        $otp = Otp::where('admin_id', $admin->id)->latest()->first();

        if (! $otp) {
            return ['valid' => false, 'pesan' => 'Tidak ada OTP aktif. Silakan login ulang.'];
        }

        if ($otp->hasExceededAttempts()) {
            return ['valid' => false, 'pesan' => 'Terlalu banyak percobaan. Silakan login ulang.'];
        }

        if ($otp->isExpired()) {
            $otp->delete();
            return ['valid' => false, 'pesan' => 'OTP sudah kedaluwarsa. Silakan login ulang.'];
        }

        // Tambah percobaan
        $otp->increment('attempts');

        if (! Hash::check($kode, $otp->kode_hash)) {
            $sisa = self::MAX_ATTEMPTS - $otp->attempts;
            return [
                'valid' => false,
                'pesan' => "Kode OTP salah. Sisa percobaan: {$sisa}.",
            ];
        }

        $otp->delete();
        return ['valid' => true, 'pesan' => 'OTP valid.'];
    }
}
