<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SiDamar - Informasi Panduan Layanan SAMSAT Manyar Surabaya Timur">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <title>@yield('title', 'SiDamar - Informasi Panduan Layanan SAMSAT Manyar')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#EEF5FB] min-h-screen font-body text-gray-800 antialiased flex flex-col justify-between">

    <header>
        {{-- Top Contact Bar --}}
        <div class="bg-[#072448] text-white text-[11px] sm:text-xs py-2 px-4 sm:px-6 lg:px-10 border-b border-blue-900/40">
            <div class="max-w-screen-2xl mx-auto flex flex-wrap items-center justify-between sm:justify-end gap-x-6 gap-y-1">
                <a href="tel:+6281246907164" class="inline-flex items-center gap-1.5 text-blue-200 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>+62 812-4690-7164</span>
                </a>
                <a href="mailto:samsatmanyar@gmail.com" class="inline-flex items-center gap-1.5 text-blue-200 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>samsatmanyar@gmail.com</span>
                </a>
                <a href="https://samsatsurabayatimur.dipendajatim.go.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-blue-200 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                    <span class="hidden md:inline">samsatsurabayatimur.dipendajatim.go.id</span>
                    <span class="md:hidden">Website Resmi</span>
                </a>
            </div>
        </div>

        {{-- Main Navbar --}}
        <nav class="bg-[#0B4DA2] text-white shadow-md sticky top-0 z-50" x-data="{ mobileOpen: false }">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">
                <div class="flex items-center justify-between py-3.5">
                    {{-- Logo & Brand Text --}}
                    <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-white/10 border border-white/20 rounded-xl flex items-center justify-center text-white shrink-0 shadow-sm backdrop-blur-sm group-hover:bg-white/20 transition">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-heading font-extrabold text-xl tracking-tight leading-tight block text-white">SiDamar</span>
                            <span class="text-blue-100/90 text-[11px] sm:text-xs leading-tight block">Informasi Panduan Layanan SAMSAT Manyar · Portal Layanan Publik KB SAMSAT Surabaya Timur</span>
                        </div>
                    </a>

                    {{-- Quick Action / Admin Portal (Interactive Active State) --}}
                    <div class="hidden md:flex items-center gap-1.5">
                        @if(request()->routeIs('layanan.*'))
                            <a href="{{ route('beranda') }}"
                               class="mr-2 px-3 py-1.5 rounded-lg text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors inline-flex items-center gap-1 border border-white/20 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span>Kembali</span>
                            </a>
                        @endif
                        <a href="{{ route('beranda') }}"
                           class="px-3.5 py-1.5 rounded-lg text-xs transition-all duration-200 {{ request()->routeIs('beranda') ? 'bg-white text-[#0B4DA2] font-bold shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/15 font-semibold' }}">
                            Beranda
                        </a>
                        <a href="{{ route('masukan.create') }}"
                           class="px-3.5 py-1.5 rounded-lg text-xs transition-all duration-200 {{ request()->routeIs('masukan.*') ? 'bg-white text-[#0B4DA2] font-bold shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/15 font-semibold' }}">
                            Kritik &amp; Saran
                        </a>
                        <a href="{{ route('admin.login') }}"
                           class="px-3.5 py-1.5 rounded-lg text-xs transition-all duration-200 {{ request()->routeIs('admin.*') ? 'bg-white text-[#0B4DA2] font-bold shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/15 font-semibold' }}">
                            Admin Portal
                        </a>
                    </div>

                    {{-- Mobile menu button --}}
                    <button x-on:click="mobileOpen = !mobileOpen"
                            class="md:hidden p-2 rounded-lg hover:bg-white/10 transition-colors text-white"
                            aria-label="Menu" aria-expanded="mobileOpen">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Drawer --}}
            <div x-show="mobileOpen" x-transition class="md:hidden border-t border-blue-400/20 bg-[#09418A] px-4 py-3 space-y-1">
                @if(request()->routeIs('layanan.*'))
                    <a href="{{ route('beranda') }}"
                       class="block px-3 py-2 rounded-lg text-sm font-bold text-accent-yellow hover:bg-white/10 mb-1 border-b border-blue-400/20">
                        &larr; Kembali ke Beranda
                    </a>
                @endif
                <a href="{{ route('beranda') }}"
                   class="block px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('beranda') ? 'bg-white text-[#0B4DA2] font-bold shadow-sm' : 'text-white hover:bg-white/10' }}">
                    Beranda
                </a>
                <a href="{{ route('masukan.create') }}"
                   class="block px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('masukan.*') ? 'bg-white text-[#0B4DA2] font-bold shadow-sm' : 'text-white hover:bg-white/10' }}">
                    Kritik &amp; Saran
                </a>
                <a href="{{ route('admin.login') }}"
                   class="block px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.*') ? 'bg-white text-[#0B4DA2] font-bold shadow-sm' : 'text-white hover:bg-white/10' }}">
                    Admin Portal
                </a>
            </div>
        </nav>
    </header>

    @if(session('success'))
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10 mt-4 w-full">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    {{-- Footer matching mockup --}}
    <footer class="bg-[#0B4DA2] text-white border-t border-blue-900/30">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10 pt-10 pb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-blue-400/20">
                {{-- Column 1: SiDamar Info --}}
                <div>
                    <h3 class="font-heading font-extrabold text-base text-white tracking-wide">SiDamar</h3>
                    <p class="text-xs text-blue-200 mt-1 leading-relaxed">
                        Informasi Panduan Layanan SAMSAT Manyar
                    </p>
                </div>

                {{-- Column 2: Kontak --}}
                <div>
                    <h4 class="text-xs font-bold tracking-wider text-blue-200 uppercase mb-3">KONTAK</h4>
                    <div class="space-y-1.5 text-xs text-blue-100">
                        <p>Jl. Manyar Kertoarjo No. 1, Surabaya Timur</p>
                        <p>+62 812-4690-7164</p>
                        <p>samsatmanyar@gmail.com</p>
                    </div>
                </div>

                {{-- Column 3: Jam Layanan --}}
                <div>
                    <h4 class="text-xs font-bold tracking-wider text-blue-200 uppercase mb-3">JAM LAYANAN</h4>
                    <div class="space-y-1.5 text-xs text-blue-100">
                        <p>Senin – Kamis: 08.00 – 14.00 WIB</p>
                        <p>Jumat: 08.00 – 11.00 WIB</p>
                        <p>Sabtu: 08.00 – 14.00 WIB</p>
                    </div>
                </div>
            </div>

            {{-- Bottom copyright bar --}}
            <div class="pt-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-blue-200">
                <div>
                    &copy; {{ date('Y') }} KB SAMSAT Surabaya Timur · Dinas Pendapatan Provinsi Jawa Timur
                </div>
                <div>
                    <a href="https://samsatsurabayatimur.dipendajatim.go.id" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">
                        samsatsurabayatimur.dipendajatim.go.id
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
