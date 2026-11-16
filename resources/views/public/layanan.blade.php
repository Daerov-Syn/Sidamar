@extends('layouts.public')

@section('title', 'Layanan - SiDamar Samsat Manyar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="font-heading text-3xl font-bold text-gray-900">Layanan Samsat Manyar</h1>
        <p class="text-gray-500 mt-2">Temukan informasi persyaratan dan alur pelayanan yang Anda butuhkan.</p>
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-8">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Cari layanan..." class="input-field sm:max-w-xs">
        <select name="kategori" class="input-field sm:w-48">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                    {{ $kat->nama }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Cari</button>
        @if(request()->hasAny(['q', 'kategori']))
            <a href="{{ route('layanan.index') }}" class="btn-secondary">Reset</a>
        @endif
    </form>

    @if($layanan->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-lg font-medium">Tidak ada layanan ditemukan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($layanan as $l)
            <a href="{{ route('layanan.show', $l->slug) }}"
               class="card hover:border-l-4 hover:border-primary-600 group block transition-all">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-heading font-extrabold text-lg flex-shrink-0"
                         style="background-color: {{ $l->warna }}">
                        {{ strtoupper(substr($l->nama, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <h2 class="font-heading font-semibold text-gray-900 group-hover:text-primary-700 transition-colors leading-tight">
                            {{ $l->nama }}
                        </h2>
                        <span class="badge mt-1" style="background-color:{{ $l->kategori->warna }}20; color:{{ $l->kategori->warna }}">
                            {{ $l->kategori->nama }}
                        </span>
                    </div>
                </div>
                @if($l->deskripsi)
                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $l->deskripsi }}</p>
                @endif
                <div class="flex gap-4 text-xs text-gray-400 font-mono">
                    <span>📄 {{ $l->berkas_count }} berkas</span>
                    <span>📋 {{ $l->langkah_count }} langkah</span>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
