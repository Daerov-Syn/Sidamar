@extends('layouts.auth')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="w-full max-w-sm sm:max-w-md mx-auto">
    <!-- Header Form -->
    <div class="mb-6 sm:mb-8 text-center">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] mb-2 font-heading tracking-tight">
            Verifikasi OTP
        </h1>
        <p class="text-slate-500 text-xs sm:text-sm md:text-base leading-relaxed">
            Kode OTP 6 digit telah dikirim ke email Anda. Masukkan kode tersebut di bawah.
        </p>
    </div>

    @if(session('dev_otp_code'))
        <div class="bg-amber-50 border border-amber-300 text-amber-900 px-4 py-3 rounded-xl text-xs sm:text-sm mb-5 shadow-sm">
            <div class="flex items-center gap-2 font-semibold text-amber-800 mb-1">
                <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>Info Pengiriman Email (SMTP):</span>
            </div>
            <p class="text-xs text-amber-700 mb-2 leading-relaxed">
                @if(session('otp_mail_error'))
                    Pengiriman email OTP gagal ({{ session('otp_mail_error') }}). Agar Anda tetap dapat login sekarang, gunakan kode OTP berikut:
                @else
                    Mailer saat ini dalam mode <code>log</code> atau konfigurasi SMTP belum lengkap. Agar Anda tetap dapat login sekarang, gunakan kode OTP berikut:
                @endif
            </p>
            <div class="text-center font-mono font-bold text-xl sm:text-2xl tracking-widest text-primary-800 bg-white py-2 rounded-lg border border-amber-200 shadow-sm">
                {{ session('dev_otp_code') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-xs sm:text-sm mb-5 shadow-sm flex items-start gap-2.5">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">{{ $errors->first() }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.otp.verify') }}" class="space-y-4 sm:space-y-5">
        @csrf

        <div>
            <label for="kode" class="block text-xs sm:text-sm font-bold text-[#1e293b] mb-1.5 sm:mb-2 text-center">
                Kode Verifikasi OTP
            </label>
            <input type="text"
                   id="kode"
                   name="kode"
                   autocomplete="one-time-code"
                   inputmode="numeric"
                   pattern="[0-9]{6}"
                   maxlength="6"
                   class="w-full px-3 sm:px-4 py-2.5 sm:py-3.5 rounded-xl border border-slate-300 text-center text-2xl sm:text-3xl font-mono font-bold tracking-[0.25em] sm:tracking-[0.4em] text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0d47a1] focus:border-transparent transition-all shadow-sm @error('kode') border-red-400 ring-1 ring-red-400 @enderror"
                   placeholder="000000"
                   required
                   autofocus>
            @error('kode')
                <p class="text-red-500 text-xs mt-1.5 text-center font-medium">{{ $message }}</p>
            @enderror
        </div>

        <p class="text-xs text-slate-400 text-center">
            Kode berlaku 5 menit. Maksimal 5 percobaan.
        </p>

        <div class="pt-2 sm:pt-3">
            <button type="submit"
                    class="w-full bg-[#0B4DA2] hover:bg-[#08387F] text-white font-bold py-3 sm:py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm tracking-wide active:scale-[0.99] cursor-pointer">
                Verifikasi &amp; Masuk
            </button>
        </div>
    </form>

    <div class="mt-6 sm:mt-8 text-center">
        <a href="{{ route('admin.login') }}" class="inline-flex items-center text-xs sm:text-sm font-semibold text-slate-500 hover:text-[#0d47a1] transition-colors gap-1 group py-1 px-2.5 rounded-lg hover:bg-slate-50">
            <span class="transition-transform group-hover:-translate-x-0.5">&lt;</span> Kembali ke Login
        </a>
    </div>
</div>
@endsection
