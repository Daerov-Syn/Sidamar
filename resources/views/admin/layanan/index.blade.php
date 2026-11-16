@extends('layouts.admin')

@section('title', 'Kelola Layanan - Panel Admin SiDamar')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F2851] tracking-tight">
                Kelola Layanan
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Edit persyaratan berkas dan alur langkah untuk setiap jenis layanan.
            </p>
        </div>
        <a href="{{ route('admin.layanan.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0B4DA2] hover:bg-blue-800 text-white font-bold text-xs sm:text-sm shadow-sm transition active:scale-95 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Layanan</span>
        </a>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-3xl border border-[#D9E7F4] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-white">
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase">
                            LAYANAN
                        </th>
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase">
                            KATEGORI
                        </th>
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase text-center">
                            BERKAS
                        </th>
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase text-center">
                            LANGKAH
                        </th>
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase text-right">
                            
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($layanan as $l)
                        @php
                            $colors = [
                                'lapor-jual' => ['bar' => '#1E88E5', 'pill_bg' => '#EBF3FC', 'pill_text' => '#1E70D0'],
                                'mutasi-keluar' => ['bar' => '#8E24AA', 'pill_bg' => '#F3E8FF', 'pill_text' => '#7E22CE'],
                                'mutasi-masuk' => ['bar' => '#00897B', 'pill_bg' => '#F3E8FF', 'pill_text' => '#7E22CE'],
                                'kendaraan-baru' => ['bar' => '#16A34A', 'pill_bg' => '#E8F8EE', 'pill_text' => '#16A34A'],
                                'stnk-duplikat' => ['bar' => '#0284C7', 'pill_bg' => '#E0F2FE', 'pill_text' => '#0284C7'],
                                'perpanjangan-5-tahunan' => ['bar' => '#7C3AED', 'pill_bg' => '#F5F3FF', 'pill_text' => '#6D28D9'],
                                'bbn-intern' => ['bar' => '#EA580C', 'pill_bg' => '#FFEDD5', 'pill_text' => '#C2410C'],
                            ];
                            $c = $colors[$l->slug] ?? ['bar' => '#0B4DA2', 'pill_bg' => '#EAF2FB', 'pill_text' => '#1E70D0'];
                        @endphp
                        <tr class="hover:bg-[#F9FBFE] transition group">
                            {{-- Layanan with colored left vertical indicator bar --}}
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3.5">
                                    <span class="w-1.5 h-10 rounded-full shrink-0" style="background-color: {{ $c['bar'] }}"></span>
                                    <div>
                                        <span class="font-extrabold text-[#0F2851] text-sm sm:text-base block group-hover:text-[#1E70D0] transition">
                                            {{ $l->nama }}
                                        </span>
                                        <span class="text-xs text-gray-400 block truncate max-w-xs mt-0.5">
                                            {{ $l->deskripsi ?: 'Layanan resmi Samsat Manyar' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori Pill --}}
                            <td class="py-5 px-6 whitespace-nowrap">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold"
                                      style="background-color: {{ $c['pill_bg'] }}; color: {{ $c['pill_text'] }};">
                                    {{ $l->kategori->nama ?? 'Layanan' }}
                                </span>
                            </td>

                            {{-- Berkas Count --}}
                            <td class="py-5 px-6 text-center font-bold text-gray-700 text-sm">
                                {{ $l->berkas_count ?: count($l->berkas ?? []) }}
                            </td>

                            {{-- Langkah Count --}}
                            <td class="py-5 px-6 text-center font-bold text-gray-700 text-sm">
                                {{ $l->langkah_count ?: count($l->langkah ?? []) }}
                            </td>

                            {{-- Action Edit & Hapus --}}
                            <td class="py-5 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.layanan.edit', $l->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-blue-200 text-[#1E70D0] hover:bg-blue-50 font-bold text-xs shadow-xs hover:shadow transition transform active:scale-95"
                                       title="Edit Layanan">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('admin.layanan.destroy', $l->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan \'{{ addslashes($l->nama) }}\'? Semua berkas dan alur langkah terkait akan ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 font-bold text-xs shadow-xs hover:shadow transition transform active:scale-95"
                                                title="Hapus Layanan">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400 text-sm italic">
                                Belum ada data layanan yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

