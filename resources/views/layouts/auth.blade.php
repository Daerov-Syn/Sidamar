<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') — SiDamar Admin</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-gray-800 antialiased selection:bg-[#0B4DA2] selection:text-white">
    <div class="min-h-screen md:h-screen flex flex-col md:flex-row w-full bg-white shadow-2xl overflow-x-hidden md:overflow-hidden">

        <!-- PANEL KIRI: Banner Maskot & Ilustrasi (Desktop & Tablet) -->
        <aside class="hidden md:flex md:w-5/12 lg:w-1/2 bg-[#0D47A1] relative items-center justify-center overflow-hidden select-none h-full p-0">
            <img src="{{ asset('images/sidamar-admin-banner-clean.png') }}"
                 alt="SiDamar Admin Portal"
                 class="w-full h-full object-cover object-center block select-none pointer-events-none transition-transform duration-700 hover:scale-[1.01]">
        </aside>

        <!-- HEADER MOBILE: Banner Maskot Khusus Layar HP (< 768px) -->
        <header class="md:hidden w-full bg-[#0B4DA2] pt-8 pb-10 px-6 text-white relative overflow-hidden flex flex-col items-center justify-center rounded-b-[2rem] shadow-lg">
            <div class="absolute -top-12 -left-12 w-44 h-44 rounded-full bg-white/10 pointer-events-none blur-sm"></div>
            <div class="absolute -bottom-16 -right-16 w-52 h-52 rounded-full bg-white/5 pointer-events-none blur-sm"></div>
            <div class="absolute top-6 right-8 w-16 h-16 rounded-full bg-[#FCE184]/20 pointer-events-none"></div>

            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 p-2.5 shadow-xl flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold font-heading tracking-tight text-white mb-0.5">
                    SiDamar Admin
                </h2>
                <div class="inline-flex items-center gap-2 text-[11px] font-bold tracking-[0.25em] uppercase text-blue-200 mt-1">
                    <span class="w-4 h-px bg-blue-300/60"></span>
                    ADMIN PORTAL
                    <span class="w-4 h-px bg-blue-300/60"></span>
                </div>
            </div>
        </header>

        <!-- PANEL KANAN: Form Adaptif -->
        <main class="w-full md:w-7/12 lg:w-1/2 flex flex-col h-full bg-white flex-1 relative overflow-y-auto">
            <!-- Navigasi Kembali ke Portal Publik -->
            <div class="p-5 sm:p-6 lg:p-8 pb-0 flex items-center justify-between">
                <a href="{{ route('beranda') }}"
                   class="inline-flex items-center text-xs sm:text-sm font-semibold text-slate-500 hover:text-[#0B4DA2] transition-colors gap-1.5 group py-1 px-2.5 -ml-2.5 rounded-lg hover:bg-slate-50">
                    <span class="text-base sm:text-lg leading-none transition-transform group-hover:-translate-x-1">&lt;</span>
                    Kembali ke Portal Publik
                </a>
            </div>

            <!-- Form Content -->
            <div class="flex-1 flex items-center justify-center px-6 sm:px-10 lg:px-14 py-6 sm:py-8">
                @yield('content')
            </div>

            <!-- Footer Hak Cipta -->
            <footer class="py-3 sm:py-4 text-center text-xs text-slate-400 border-t border-slate-100">
                &copy; {{ date('Y') }} SiDamar &bull; Samsat Manyar Surabaya
            </footer>
        </main>
    </div>
</body>
</html>