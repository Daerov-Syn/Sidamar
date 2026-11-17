<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — SiDamar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#EDF4FA] font-body text-gray-800 antialiased min-h-screen" x-data="{ sidebarOpen: false }">
<div class="flex min-h-screen">

    {{-- Sidebar Matching Mockup --}}
    <aside class="fixed inset-y-0 left-0 z-40 w-64 sm:w-72 bg-[#0B4DA2] text-white flex flex-col justify-between
                  transform transition-transform duration-200 ease-in-out shadow-xl
                  lg:translate-x-0 lg:static lg:flex-shrink-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <div>
            {{-- Logo Header --}}
            <div class="p-6 border-b border-white/10 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-white/15 border border-white/20 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-sm backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-heading font-extrabold text-xl leading-tight block text-white tracking-tight">SiDamar</span>
                        <span class="text-blue-200 text-xs leading-tight block mt-0.5">Panel Admin</span>
                    </div>
                </div>
            </div>

            {{-- Nav Links --}}
            <nav class="p-4 space-y-2 overflow-y-auto">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs sm:text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#0B4DA2] shadow-sm font-bold' : 'bg-white/10 text-white hover:bg-white/20' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- Kelola Layanan --}}
                <a href="{{ route('admin.layanan.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs sm:text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.layanan.*') ? 'bg-white text-[#0B4DA2] shadow-sm font-bold' : 'bg-white/10 text-white hover:bg-white/20' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Kelola Layanan</span>
                </a>

                {{-- Kelola Pengguna --}}
                <a href="{{ route('admin.pengguna.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs sm:text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengguna.*') ? 'bg-white text-[#0B4DA2] shadow-sm font-bold' : 'bg-white/10 text-white hover:bg-white/20' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Kelola Pengguna</span>
                </a>

                {{-- Data Masukan with Counter --}}
                @php
                    $masukanBaruCount = \App\Models\Masukan::where('status', 'Baru')->count();
                @endphp
                <a href="{{ route('admin.masukan.index') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-xs sm:text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.masukan.*') ? 'bg-white text-[#0B4DA2] shadow-sm font-bold' : 'bg-white/10 text-white hover:bg-white/20' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        <span>Data Masukan</span>
                    </div>
                    @if($masukanBaruCount > 0)
                        <span class="w-5 h-5 rounded-full bg-[#E5252A] text-white text-[11px] font-bold flex items-center justify-center shrink-0 shadow-sm">
                            {{ $masukanBaruCount }}
                        </span>
                    @endif
                </a>
            </nav>
        </div>

        {{-- Bottom Profile & Logout --}}
        <div class="p-4 space-y-2.5 border-t border-white/10 flex-shrink-0">
            {{-- User Pill --}}
            <div class="bg-white rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-[#0B4DA2] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <span class="block text-xs font-bold text-[#0F2851] truncate">Administrator</span>
                    <span class="block text-[10px] text-gray-400 truncate">{{ auth('admin')->user()->username ?? 'admin' }}</span>
                </div>
            </div>

            {{-- Logout Button --}}
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-[#E5252A] hover:bg-red-700 text-white font-bold text-xs p-3 rounded-2xl flex items-center gap-2.5 shadow-sm transition active:scale-98">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar dari sistem</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div x-cloak
         x-show="sidebarOpen"
         x-on:click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-30 lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:leave="transition-opacity ease-linear duration-200"></div>

    {{-- Main Area --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#EDF4FA]">
        {{-- Mobile Hamburger Bar --}}
        <div class="lg:hidden bg-[#0B4DA2] text-white p-4 flex items-center justify-between shadow-sm">
            <button x-on:click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-xl hover:bg-white/10 transition"
                    aria-label="Toggle sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="font-bold text-sm">SiDamar Admin</span>
            <div class="w-8"></div>
        </div>

        {{-- Flash Alerts --}}
        @if(session('success'))
            <div class="mx-6 sm:mx-10 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3 rounded-2xl text-xs sm:text-sm flex items-center gap-2.5 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mx-6 sm:mx-10 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-2xl text-xs sm:text-sm flex items-center gap-2.5 shadow-sm">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <main class="flex-1 p-6 sm:p-8 lg:p-10 overflow-y-auto">
            <div class="max-w-[1440px] mx-auto w-full">
                @yield('content')
            </div>
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
