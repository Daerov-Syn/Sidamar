@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Panel Admin SiDamar')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F2851] tracking-tight">
                Kelola Pengguna
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Kelola akun administrator yang memiliki akses ke Panel Admin SiDamar.
            </p>
        </div>
        <a href="{{ route('admin.pengguna.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0B4DA2] hover:bg-blue-800 text-white font-bold text-xs sm:text-sm shadow-sm transition active:scale-95 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-3xl border border-[#D9E7F4] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-white">
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase">
                            PENGGUNA
                        </th>
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase">
                            EMAIL
                        </th>
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase">
                            TANGGAL DIBUAT
                        </th>
                        <th class="py-4 px-6 text-[11px] font-bold tracking-widest text-gray-400 uppercase text-right">
                            AKSI
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($pengguna as $p)
                        @php
                            $isCurrentAdmin = auth('admin')->id() === $p->id;
                        @endphp
                        <tr class="hover:bg-[#F9FBFE] transition group">
                            {{-- Username & Avatar --}}
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-[#0B4DA2] font-extrabold text-sm flex items-center justify-center shrink-0 shadow-2xs">
                                        {{ strtoupper(substr($p->username, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-extrabold text-[#0F2851] text-sm sm:text-base block group-hover:text-[#1E70D0] transition">
                                                {{ $p->username }}
                                            </span>
                                            @if($isCurrentAdmin)
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-blue-100 text-[#0B4DA2] border border-blue-200">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-400 block mt-0.5">
                                            Administrator
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="py-5 px-6 whitespace-nowrap text-gray-600 font-medium">
                                {{ $p->email }}
                            </td>

                            {{-- Tanggal Dibuat --}}
                            <td class="py-5 px-6 whitespace-nowrap text-gray-500 text-xs">
                                {{ $p->created_at ? $p->created_at->format('d M Y, H:i') : '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="py-5 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.pengguna.edit', $p->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-blue-200 text-[#1E70D0] hover:bg-blue-50 font-bold text-xs shadow-xs hover:shadow transition transform active:scale-95"
                                       title="Edit Pengguna">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    @if(!$isCurrentAdmin)
                                        <form action="{{ route('admin.pengguna.destroy', $p->id) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin \'{{ addslashes($p->username) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 font-bold text-xs shadow-xs hover:shadow transition transform active:scale-95"
                                                    title="Hapus Pengguna">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center px-3 py-2 rounded-xl text-gray-400 text-xs font-semibold" title="Akun Anda sedang aktif">
                                            -
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-400 text-sm italic">
                                Belum ada data pengguna yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

