@extends('layouts.public')

@section('title', 'SiDamar - Informasi Panduan Layanan SAMSAT Manyar')

@section('content')
{{-- Hero Section --}}
<section class="bg-[#0B4DA2] text-white pt-8 pb-14 overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            {{-- Left column --}}
            <div class="lg:col-span-7 space-y-5">
                {{-- Self-Service Badge --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-900/50 border border-blue-400/30 text-xs font-medium text-blue-100 shadow-sm backdrop-blur-sm">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Self-Service · Tanpa Login · Tanpa NIK</span>
                </div>

                {{-- Headline --}}
                <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-white leading-tight tracking-tight">
                    Informasi Persyaratan &<br class="hidden sm:inline">
                    Alur Layanan Mandiri
                </h1>

                {{-- Subtitle --}}
                <p class="text-blue-100/90 text-sm sm:text-base max-w-xl leading-relaxed">
                    Cari tahu dokumen yang perlu disiapkan dan urutan loket yang harus dilalui sebelum datang ke SAMSAT Surabaya Timur.
                </p>

                {{-- Info Badges --}}
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    {{-- Clock / Schedule --}}
                    <div class="flex items-center gap-3 bg-blue-900/40 border border-blue-400/20 rounded-2xl px-4 py-2.5 backdrop-blur-sm shadow-sm">
                        <div class="w-9 h-9 rounded-xl bg-blue-800/80 flex items-center justify-center text-blue-200 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-[11px] text-blue-200 leading-tight">Senin–Sabtu</span>
                            <span class="block text-xs sm:text-sm font-bold text-white leading-tight mt-0.5">08.00–14.00 WIB</span>
                        </div>
                    </div>

                    {{-- Map Pin / Location --}}
                    <div class="flex items-center gap-3 bg-blue-900/40 border border-blue-400/20 rounded-2xl px-4 py-2.5 backdrop-blur-sm shadow-sm">
                        <div class="w-9 h-9 rounded-xl bg-blue-800/80 flex items-center justify-center text-blue-200 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-[11px] text-blue-200 leading-tight">Jl. Manyar Kertoarjo No. 1</span>
                            <span class="block text-xs sm:text-sm font-bold text-white leading-tight mt-0.5">Surabaya Timur</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right column: Mascot Graphic matching mockup --}}
            <div class="lg:col-span-5 flex justify-center lg:justify-end mt-4 lg:mt-0">
                <div class="relative w-72 sm:w-80 md:w-96 lg:w-[420px] select-none">
                    <img src="{{ asset('images/hero-mascot-transparent.png') }}"
                         alt="Maskot SiDamar Samsat Manyar"
                         class="w-full h-auto object-contain"
                         loading="eager">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Services Section ("Pilih Jenis Layanan") --}}
<section class="bg-[#EEF5FB] py-10 lg:py-14">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">
        {{-- Section Header --}}
        <div>
            <h2 class="text-2xl font-bold text-[#0F2851] tracking-tight">Pilih Jenis Layanan</h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Klik layanan untuk melihat dokumen yang harus disiapkan dan alur loket lengkap.
            </p>
        </div>

        {{-- Tips Box --}}
        <div class="mt-5 p-4 rounded-xl bg-[#E2EDF8] border border-[#BFDBFE] flex items-start gap-3 text-[#0F2851]">
            <div class="w-5 h-5 rounded-full bg-[#1A73E8] text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                i
            </div>
            <div class="text-xs sm:text-sm leading-relaxed">
                <span class="font-bold text-[#0F2851] block mb-0.5">Tips sebelum datang ke SAMSAT</span>
                <span class="text-gray-600">
                    Siapkan semua berkas dalam map. Bawa dokumen <strong class="font-bold text-gray-900">asli</strong> dan <strong class="font-bold text-gray-900">fotokopi</strong> sesuai jumlah yang tertera. Fotokopi berukuran A4, tidak dipotong. Bagi kendaraan yang perlu cek fisik, bawa kendaraan langsung ke SAMSAT.
                </span>
            </div>
        </div>

        {{-- 4x2 Grid of 8 Service Cards --}}
        @php
            // Custom dictionary matching mockup data
            $cardsMeta = [
                'lapor-jual' => [
                    'nama' => 'Lapor Jual',
                    'deskripsi' => 'Blokir lapor jual ERI & layanan progresif',
                    'icon' => 'ban',
                ],
                'mutasi-keluar' => [
                    'nama' => 'Mutasi Keluar',
                    'deskripsi' => 'Layanan pindah daerah / fiskal',
                    'icon' => 'logout',
                ],
                'mutasi-masuk' => [
                    'nama' => 'Mutasi Masuk',
                    'deskripsi' => 'Pendaftaran kendaraan masuk dari daerah lain',
                    'icon' => 'login',
                ],
                'kendaraan-baru' => [
                    'nama' => 'Kendaraan Baru',
                    'deskripsi' => 'Pendaftaran BPKB / STNK kendaraan baru',
                    'icon' => 'plus',
                ],
                'stnk-duplikat' => [
                    'nama' => 'STNK Duplikat',
                    'deskripsi' => 'Pengurusan STNK hilang atau rusak',
                    'icon' => 'document',
                ],
                'perpanjangan-5-tahunan' => [
                    'nama' => 'Penul 5 Tahun',
                    'deskripsi' => 'Pajak 5 tahunan, ganti plat nomor & pindah alamat',
                    'icon' => 'calendar',
                ],
                'bbn-intern' => [
                    'nama' => 'BBN Intern',
                    'deskripsi' => 'Balik nama kendaraan bermotor',
                    'icon' => 'swap',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
            @foreach($layanan as $l)
                @php
                    $meta = $cardsMeta[$l->slug] ?? null;
                    $title = $meta['nama'] ?? $l->nama;
                    $desc = $meta['deskripsi'] ?? $l->deskripsi;
                    $iconType = $meta['icon'] ?? 'document';
                    $langkahCount = $l->langkah_count ?: count($l->langkah ?? []);
                    $berkasCount = $l->berkas_count ?: count($l->berkas ?? []);
                @endphp
                <a href="{{ route('layanan.show', $l->slug) }}"
                   class="bg-white rounded-2xl border border-[#D9E7F4] p-5 shadow-sm hover:shadow-md hover:border-[#1E70D0]/50 transition-all duration-200 hover:-translate-y-0.5 flex flex-col justify-between group">
                    <div>
                        {{-- Icon Box --}}
                        <div class="w-10 h-10 rounded-xl bg-[#EAF2FB] text-[#1E70D0] flex items-center justify-center mb-3 group-hover:bg-[#1E70D0] group-hover:text-white transition-colors">
                            @if($iconType === 'ban')
                                {{-- Lapor Jual (Prohibited/slash circle) --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            @elseif($iconType === 'logout')
                                {{-- Mutasi Keluar --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            @elseif($iconType === 'login')
                                {{-- Mutasi Masuk --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            @elseif($iconType === 'plus')
                                {{-- Kendaraan Baru --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @elseif($iconType === 'calendar')
                                {{-- Penul 5 Tahun --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @elseif($iconType === 'swap')
                                {{-- BBN Intern --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            @else
                                {{-- STNK Duplikat / Default Document --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @endif
                        </div>

                        {{-- Service Title --}}
                        <h3 class="font-bold text-[#0F2851] text-sm group-hover:text-[#1E70D0] transition-colors leading-tight">
                            {{ $title }}
                        </h3>

                        {{-- Service Subtitle --}}
                        <p class="text-xs text-gray-500 mt-1.5 leading-snug">
                            {{ $desc }}
                        </p>
                    </div>

                    {{-- Badges & Link --}}
                    <div class="flex items-center justify-between mt-5 pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <span class="bg-[#EBF3FC] text-[#1E70D0] text-[11px] font-semibold px-2 py-0.5 rounded">
                                {{ $langkahCount }} langkah
                            </span>
                            <span class="text-[11px] text-gray-500 font-medium">
                                {{ $berkasCount }} berkas
                            </span>
                        </div>
                        <span class="text-xs font-bold text-[#1E70D0] group-hover:translate-x-0.5 transition-transform inline-flex items-center">
                            Lihat &gt;
                        </span>
                    </div>
                </a>
            @endforeach

            {{-- 8th Card: Kritik & Saran --}}
            <a href="{{ route('masukan.create') }}"
               class="bg-white rounded-2xl border border-[#D9E7F4] p-5 shadow-sm hover:shadow-md hover:border-[#1E70D0]/50 transition-all duration-200 hover:-translate-y-0.5 flex flex-col justify-between group">
                <div>
                    {{-- Chat Icon Box --}}
                    <div class="w-10 h-10 rounded-xl bg-[#EAF2FB] text-[#1E70D0] flex items-center justify-center mb-3 group-hover:bg-[#1E70D0] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>

                    {{-- Card Title --}}
                    <h3 class="font-bold text-[#0F2851] text-sm group-hover:text-[#1E70D0] transition-colors leading-tight">
                        Kritik &amp; Saran
                    </h3>

                    {{-- Card Subtitle --}}
                    <p class="text-xs text-gray-500 mt-1.5 leading-snug">
                        Portal masukan bagi wajib pajak
                    </p>
                </div>

                {{-- Action Link --}}
                <div class="flex items-center justify-end mt-5 pt-3 border-t border-gray-100">
                    <span class="text-xs font-bold text-[#1E70D0] group-hover:translate-x-0.5 transition-transform inline-flex items-center">
                        Buka &gt;
                    </span>
                </div>
            </a>
        </div>
    </div>
</section>
@endsection
