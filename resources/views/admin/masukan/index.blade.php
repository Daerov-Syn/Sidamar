@extends('layouts.admin')

@section('title', 'Data Masukan - Panel Admin SiDamar')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header & Filter Tabs matching Mockup --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F2851] tracking-tight">
                Data Masukan
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Kritik dan Saran Wajib Pajak
            </p>
        </div>

        {{-- Filter Tabs (Semua, Baru, Ditinjau, Selesai) --}}
        <div class="bg-white rounded-2xl p-1.5 border border-[#D9E7F4] flex flex-wrap items-center gap-1 shadow-xs self-start md:self-center">
            {{-- Semua --}}
            <a href="{{ route('admin.masukan.index') }}"
               class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ empty($status) ? 'bg-[#0B4DA2] text-white shadow-xs' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                Semua
            </a>

            {{-- Baru --}}
            <a href="{{ route('admin.masukan.index', ['status' => 'Baru']) }}"
               class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ $status === 'Baru' ? 'bg-[#0B4DA2] text-white shadow-xs' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                Baru ({{ $counts['Baru'] ?? 0 }})
            </a>

            {{-- Ditinjau --}}
            <a href="{{ route('admin.masukan.index', ['status' => 'Ditinjau']) }}"
               class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ $status === 'Ditinjau' ? 'bg-[#0B4DA2] text-white shadow-xs' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                Ditinjau ({{ $counts['Ditinjau'] ?? 0 }})
            </a>

            {{-- Selesai --}}
            <a href="{{ route('admin.masukan.index', ['status' => 'Selesai']) }}"
               class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ $status === 'Selesai' ? 'bg-[#0B4DA2] text-white shadow-xs' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                Selesai ({{ $counts['Selesai'] ?? 0 }})
            </a>
        </div>
    </div>

    {{-- Feedback Cards List --}}
    <div class="space-y-3.5">
        @forelse($masukan as $m)
            @php
                $initial = strtoupper(substr($m->nama ?: 'Anonim', 0, 1));
                $badgeStyle = match($m->status) {
                    'Baru' => 'bg-red-50 text-red-600 border border-red-200 focus:ring-red-400',
                    'Ditinjau' => 'bg-amber-50 text-amber-700 border border-amber-200 focus:ring-amber-400',
                    'Selesai' => 'bg-emerald-50 text-emerald-700 border border-emerald-200 focus:ring-emerald-400',
                    default => 'bg-gray-50 text-gray-700 border border-gray-200 focus:ring-gray-400',
                };
            @endphp
            <div class="bg-white rounded-2xl border border-[#D9E7F4] shadow-sm p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:shadow-md">
                {{-- Left details --}}
                <div class="flex items-start gap-3.5 flex-1 min-w-0">
                    {{-- Avatar Initial --}}
                    <div class="w-10 h-10 rounded-full bg-[#EBF3FC] text-[#1E70D0] font-bold text-sm flex items-center justify-center shrink-0 shadow-xs">
                        {{ $initial }}
                    </div>

                    {{-- Information --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                            <span class="font-extrabold text-sm text-[#0F2851]">
                                {{ $m->nama ?: 'Anonim' }}
                            </span>
                            @if($m->kontak)
                                <span class="text-xs text-gray-400 font-normal">
                                    ({{ $m->kontak }})
                                </span>
                            @endif

                            {{-- Star Rating --}}
                            <div class="flex items-center gap-0.5" title="{{ $m->rating }} Bintang">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $m->rating ? 'text-amber-400 fill-amber-400' : 'text-gray-200 fill-gray-200' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            {{-- Date --}}
                            <span class="text-[11px] text-gray-400">
                                {{ $m->created_at ? $m->created_at->format('d/M/Y') : '' }}
                            </span>
                        </div>

                        {{-- Text Message --}}
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                            {{ $m->isi }}
                        </p>
                    </div>
                </div>

                {{-- Right: Interactive Status Dropdown Form --}}
                <div class="shrink-0 self-end sm:self-center">
                    <form method="POST" action="{{ route('admin.masukan.update-status', $m->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="relative inline-block">
                            <select name="status"
                                    onchange="this.form.submit()"
                                    class="appearance-none font-bold text-xs px-4 py-1.5 pr-8 rounded-xl cursor-pointer transition shadow-xs focus:outline-none focus:ring-2 {{ $badgeStyle }}">
                                <option value="Baru" {{ $m->status === 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Ditinjau" {{ $m->status === 'Ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                                <option value="Selesai" {{ $m->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5">
                                <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-[#D9E7F4] p-10 text-center">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-[#0B4DA2] flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-sm text-[#0F2851]">Tidak ada data masukan</h3>
                <p class="text-xs text-gray-400 mt-1">
                    {{ $status ? "Belum ada kritik atau saran dengan status '$status'." : 'Belum ada masukan wajib pajak yang tercatat.' }}
                </p>
            </div>
        @endforelse

        {{-- Pagination if any --}}
        @if($masukan->hasPages())
            <div class="pt-4">
                {{ $masukan->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

