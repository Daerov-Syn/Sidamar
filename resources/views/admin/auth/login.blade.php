@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')
<div class="w-full max-w-sm sm:max-w-md mx-auto">
    <!-- Judul & Subjudul -->
    <div class="mb-6 sm:mb-8 text-center">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] mb-2 font-heading tracking-tight">
            Masuk ke Panel Admin
        </h1>
        <p class="text-slate-500 text-xs sm:text-sm md:text-base leading-relaxed">
            Gunakan akun yang telah didaftarkan oleh administrator
        </p>
    </div>

    <!-- Alert Notifikasi Error -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-xs sm:text-sm mb-5 shadow-sm flex items-start gap-2.5">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">{{ $errors->first() }}</div>
        </div>
    @endif

    <!-- Form Login Interaktif -->
    <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4 sm:space-y-5">
        @csrf

        <!-- Input Username -->
        <div>
            <label for="username" class="block text-xs sm:text-sm font-bold text-[#1e293b] mb-1.5 sm:mb-2">
                Username
            </label>
            <div class="relative">
                <input type="text"
                       id="username"
                       name="username"
                       value="{{ old('username') }}"
                       autocomplete="username"
                       class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-xl border border-slate-300 text-slate-800 text-sm sm:text-base placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0d47a1] focus:border-transparent transition-all shadow-sm @error('username') border-red-400 ring-1 ring-red-400 @enderror"
                       placeholder="Username admin"
                       required
                       autofocus>
            </div>
            @error('username')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Password dengan Toggle Show/Hide -->
        <div>
            <label for="password" class="block text-xs sm:text-sm font-bold text-[#1e293b] mb-1.5 sm:mb-2">
                Password
            </label>
            <div class="relative">
                <input type="password"
                       id="password"
                       name="password"
                       autocomplete="current-password"
                       class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 pr-11 sm:pr-12 rounded-xl border border-slate-300 text-slate-800 text-sm sm:text-base placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition-all shadow-sm @error('password') border-red-400 ring-1 ring-red-400 @enderror"
                       placeholder="Password"
                       required>
                <button type="button"
                        id="toggle-password"
                        onclick="togglePasswordVisibility()"
                        class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 p-2 text-slate-400 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-300 rounded-lg cursor-pointer transition-colors"
                        aria-label="Tampilkan password">
                    <!-- Icon Mata Terbuka (Tampil saat password tersembunyi / bertitik) -->
                    <svg id="eye-icon-show" class="w-5 h-5 text-slate-400 hover:text-slate-600 transition-colors block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <!-- Icon Mata Dicoret (Tampil saat password terbuka / terlihat) -->
                    <svg id="eye-icon-hide" class="w-5 h-5 text-slate-400 hover:text-slate-600 transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Submit Responsif -->
        <div class="pt-2 sm:pt-3">
            <button type="submit"
                    class="w-full bg-[#0B4DA2] hover:bg-[#08387F] text-white font-bold py-3 sm:py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm tracking-wide active:scale-[0.99] cursor-pointer">
                Lanjutkan ke Verifikasi OTP
            </button>
        </div>
    </form>
</div>

<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        const eyeShow = document.getElementById('eye-icon-show');
        const eyeHide = document.getElementById('eye-icon-hide');
        const button = document.getElementById('toggle-password');
        if (!input || !eyeShow || !eyeHide) return;

        if (input.type === 'password') {
            input.type = 'text';
            eyeShow.classList.add('hidden');
            eyeShow.classList.remove('block');
            eyeHide.classList.remove('hidden');
            eyeHide.classList.add('block');
            if (button) button.setAttribute('aria-label', 'Sembunyikan password');
        } else {
            input.type = 'password';
            eyeShow.classList.remove('hidden');
            eyeShow.classList.add('block');
            eyeHide.classList.add('hidden');
            eyeHide.classList.remove('block');
            if (button) button.setAttribute('aria-label', 'Tampilkan password');
        }
    }
</script>
    </form>
</div>
@endsection