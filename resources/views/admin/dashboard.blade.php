@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data dan aktivitas SiDamar')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl border border-[#D9E7F4] shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0B4DA2] flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium">Total Layanan</p>
            <p class="text-2xl font-extrabold text-[#0F2851] tracking-tight mt-0.5">{{ $ringkasan->total_layanan ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-[#D9E7F4] shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium">Total Masukan</p>
            <p class="text-2xl font-extrabold text-[#0F2851] tracking-tight mt-0.5">{{ $ringkasan->total_masukan ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-[#D9E7F4] shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium">Masukan Baru</p>
            <p class="text-2xl font-extrabold text-[#0F2851] tracking-tight mt-0.5">{{ $ringkasan->masukan_baru ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-[#D9E7F4] shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium">Rata-rata Rating</p>
            <p class="text-2xl font-extrabold text-[#0F2851] tracking-tight mt-0.5">{{ number_format($ringkasan->rata_rating ?? 0, 1) }} ⭐</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Layanan Aktif Card --}}
    <div class="xl:col-span-2">
        <div class="bg-white rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-extrabold text-[#0F2851]">Layanan Aktif</h2>
                <a href="{{ route('admin.layanan.index') }}"
                   class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-[#0B4DA2] hover:text-blue-800 hover:underline transition">
                    <span>Kelola</span>
                    <span>→</span>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                @forelse($layananAktif as $l)
                <a href="{{ route('admin.layanan.edit', $l) }}"
                   class="flex items-center gap-3.5 p-3.5 rounded-2xl border border-gray-100 hover:border-[#0B4DA2]/40 hover:bg-[#F8FAFD] hover:shadow-xs transition bg-white group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0 shadow-xs"
                         style="background-color: {{ $l->warna ?? '#0B4DA2' }}">
                        {{ strtoupper(substr($l->nama, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-bold text-[#0F2851] group-hover:text-[#0B4DA2] transition truncate">
                            {{ $l->nama }}
                        </p>
                        <p class="text-[11px] text-gray-400 font-mono mt-0.5">
                            {{ $l->berkas_count }} berkas · {{ $l->langkah_count }} langkah
                        </p>
                    </div>
                    <div class="w-6 h-6 rounded-lg text-gray-300 group-hover:text-[#0B4DA2] flex items-center justify-center shrink-0 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                @empty
                    <p class="text-gray-400 text-xs sm:text-sm col-span-2 py-4">Belum ada layanan aktif.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Status Masukan Card (Donut Chart) --}}
    <div>
        <div class="bg-white rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 flex flex-col justify-between h-full">
            <div>
                <h2 class="text-lg font-extrabold text-[#0F2851] mb-5">Status Masukan</h2>
                <div class="flex justify-center mb-6">
                    <div class="relative w-44 h-44 flex items-center justify-center">
                        <canvas id="donutMasukan"></canvas>
                    </div>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-[#EF4444] shrink-0"></span>
                            <span class="text-gray-600 font-medium">Baru</span>
                        </div>
                        <span class="font-mono font-bold text-[#0F2851]">{{ $statusMasukan['Baru']->jumlah ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-[#F59E0B] shrink-0"></span>
                            <span class="text-gray-600 font-medium">Ditinjau</span>
                        </div>
                        <span class="font-mono font-bold text-[#0F2851]">{{ $statusMasukan['Ditinjau']->jumlah ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-[#22C55E] shrink-0"></span>
                            <span class="text-gray-600 font-medium">Selesai</span>
                        </div>
                        <span class="font-mono font-bold text-[#0F2851]">{{ $statusMasukan['Selesai']->jumlah ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-gray-100">
                <a href="{{ route('admin.masukan.index') }}"
                   class="w-full bg-[#0B4DA2] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-xl text-xs sm:text-sm block text-center shadow-sm transition active:scale-98">
                    Lihat Semua Masukan
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Masukan Terbaru Card --}}
<div class="mt-6 bg-white rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-extrabold text-[#0F2851]">Masukan Terbaru Wajib Pajak</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kritik dan saran terkini dari wajib pajak</p>
        </div>
        <a href="{{ route('admin.masukan.index') }}"
           class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-[#0B4DA2] hover:text-blue-800 hover:underline transition">
            <span>Lihat Semua Masukan</span>
            <span>→</span>
        </a>
    </div>

    <div class="space-y-3">
        @forelse($masukanTerbaru as $m)
            @php
                $initial = strtoupper(substr($m->nama ?: 'Anonim', 0, 1));
                $badgeStyle = match($m->status) {
                    'Baru' => 'bg-red-50 text-red-600 border border-red-200',
                    'Ditinjau' => 'bg-amber-50 text-amber-700 border border-amber-200',
                    'Selesai' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                    default => 'bg-gray-50 text-gray-700 border border-gray-200',
                };
            @endphp
            <div class="p-3.5 sm:p-4 rounded-2xl border border-gray-100 hover:border-[#0B4DA2]/30 hover:bg-[#F9FBFE] transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-start gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-full bg-[#EBF3FC] text-[#1E70D0] font-bold text-xs flex items-center justify-center shrink-0">
                        {{ $initial }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-xs sm:text-sm text-[#0F2851] truncate">{{ $m->nama ?: 'Anonim' }}</span>
                            @if($m->kontak)
                                <span class="text-[11px] text-gray-400 font-normal">({{ $m->kontak }})</span>
                            @endif
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3 h-3 {{ $i <= $m->rating ? 'text-amber-400 fill-amber-400' : 'text-gray-200 fill-gray-200' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-[10px] text-gray-400">{{ $m->created_at ? $m->created_at->diffForHumans() : '' }}</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1 line-clamp-1 sm:line-clamp-2">{{ $m->isi }}</p>
                    </div>
                </div>
                <div class="shrink-0 self-start sm:self-center">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $badgeStyle }}">
                        {{ $m->status }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-xs sm:text-sm py-4 text-center italic">Belum ada masukan wajib pajak.</p>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const ctx = document.getElementById('donutMasukan');
    if (!ctx) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Baru', 'Ditinjau', 'Selesai'],
            datasets: [{
                data: [
                    {{ $statusMasukan['Baru']->jumlah ?? 0 }},
                    {{ $statusMasukan['Ditinjau']->jumlah ?? 0 }},
                    {{ $statusMasukan['Selesai']->jumlah ?? 0 }},
                ],
                backgroundColor: ['#EF4444', '#F59E0B', '#22C55E'],
                borderWidth: 3,
                borderColor: '#fff',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            cutout: '70%',
        },
    });
})();
</script>
@endpush
