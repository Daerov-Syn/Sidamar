@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru - Panel Admin SiDamar')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F2851] tracking-tight">
                Tambah Pengguna Baru
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Daftarkan akun administrator baru untuk mengelola portal SiDamar.
            </p>
        </div>

        <a href="{{ route('admin.pengguna.index') }}"
           class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-gray-600 hover:text-[#0B4DA2] transition self-start sm:self-auto group">
            <svg class="w-4 h-4 text-gray-500 group-hover:text-[#0B4DA2] transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Kembali ke Daftar Pengguna</span>
        </a>
    </div>

    {{-- Error Banner --}}
    @if(isset($errors) && $errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="font-bold">Mohon periksa kembali form:</p>
                <ul class="list-disc list-inside mt-1 space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.pengguna.store') }}" class="space-y-5">
            @csrf

            {{-- Username --}}
            <div>
                <label for="username" class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Username
                </label>
                <input type="text"
                       id="username"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       placeholder="Contoh: admin2"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                <p class="text-[11px] text-gray-400 mt-1">Digunakan untuk login ke panel admin.</p>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Alamat Email
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       placeholder="Contoh: petugas@samsat-manyar.id"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                <p class="text-[11px] text-gray-400 mt-1">Digunakan untuk menerima kode verifikasi OTP saat login.</p>
            </div>

            {{-- Password --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <div>
                    <label for="password" class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           minlength="6"
                           placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Konfirmasi Password
                    </label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           minlength="6"
                           placeholder="Ulangi password"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.pengguna.index') }}"
                   class="px-6 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-bold shadow-2xs transition active:scale-98">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 sm:px-7 py-2.5 rounded-xl bg-[#0B4DA2] hover:bg-blue-800 text-white text-xs sm:text-sm font-bold shadow-sm transition flex items-center gap-2 active:scale-98">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Simpan Pengguna</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

