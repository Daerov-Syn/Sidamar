@extends('layouts.admin')

@section('title', 'Tambah Layanan Baru - Panel Admin')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Top Header with Back Link on Right --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F2851] tracking-tight">
                Tambah Layanan Baru
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Layanan yang ditambahkan akan langsung tampil di portal wajib pajak setelah disimpan.
            </p>
        </div>

        <a href="{{ route('admin.layanan.index') }}"
           class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-gray-600 hover:text-[#0B4DA2] transition self-start sm:self-auto group">
            <svg class="w-4 h-4 text-gray-500 group-hover:text-[#0B4DA2] transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Kembali ke Daftar Layanan</span>
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

    {{-- Main Form --}}
    <form method="POST" action="{{ route('admin.layanan.store') }}" class="space-y-6" id="form-create-layanan">
        @csrf

        {{-- CARD 1: Informasi Dasar --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 space-y-5">
            {{-- Card Header --}}
            <div class="flex items-center gap-2.5 pb-2">
                <div class="w-7 h-7 rounded-full border border-blue-200 bg-blue-50 text-[#1E70D0] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-width="2" d="M12 8h.01M12 12v4"/>
                    </svg>
                </div>
                <h2 class="text-sm sm:text-base font-bold text-[#0F2851]">
                    Informasi Dasar
                </h2>
            </div>

            {{-- Row 1: Nama Layanan & Kategori --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="nama" class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Nama Layanan
                    </label>
                    <input type="text"
                           id="nama"
                           name="nama"
                           value="{{ old('nama') }}"
                           required
                           placeholder="Contoh: Balik Nama Luar Daerah"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                </div>

                <div>
                    <label for="kategori_id" class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Kategori
                    </label>
                    <div class="relative">
                        <select id="kategori_id"
                                name="kategori_id"
                                required
                                class="w-full appearance-none px-4 py-2.5 pr-10 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 2: Deskripsi Singkat --}}
            <div>
                <label for="deskripsi" class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Deskripsi Singkat
                </label>
                <input type="text"
                       id="deskripsi"
                       name="deskripsi"
                       value="{{ old('deskripsi') }}"
                       placeholder="Contoh: Pengurusan mutasi dan balik nama dari luar daerah"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
            </div>
        </div>

        {{-- CARD 2: Persyaratan Berkas --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 space-y-5">
            {{-- Card Header with + Tambah Berkas --}}
            <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full border border-blue-200 bg-blue-50 text-[#1E70D0] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm sm:text-base font-bold text-[#0F2851]">
                        Persyaratan Berkas (<span id="berkas-count">1</span>)
                    </h2>
                </div>

                <button type="button"
                        onclick="addBerkasRow()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full border border-[#1E70D0]/30 hover:border-[#1E70D0] bg-white hover:bg-blue-50 text-[#1E70D0] font-bold text-xs transition shadow-2xs cursor-pointer active:scale-95">
                    <span>+ Tambah Berkas</span>
                </button>
            </div>

            {{-- Berkas Items List --}}
            <div class="space-y-6" id="berkas-container">
                <div class="berkas-row flex items-start gap-4 p-3 rounded-2xl transition hover:bg-gray-50/70 border border-transparent hover:border-gray-200">
                    {{-- Left Column: Number Badge & Trash Icon --}}
                    <div class="flex flex-col items-center shrink-0 pt-1">
                        <div class="berkas-num w-6 h-6 rounded-full bg-[#EBF3FC] text-[#1E70D0] font-bold text-xs flex items-center justify-center shadow-2xs">
                            1
                        </div>
                        <button type="button"
                                onclick="removeBerkasRow(this)"
                                class="w-6 h-6 mt-2 rounded-full bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition shadow-2xs cursor-pointer"
                                title="Hapus berkas ini">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Right Column: Inputs --}}
                    <div class="flex-1 space-y-3 min-w-0">
                        {{-- Row 1: Nama Berkas + Tombol Hapus Text --}}
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                                    Nama Berkas
                                </label>
                                <button type="button"
                                        onclick="removeBerkasRow(this)"
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer"
                                        title="Hapus berkas ini">
                                    <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </div>
                            <input type="text"
                                   name="berkas[0][nama]"
                                   value=""
                                   placeholder="Contoh: KTP Asli Pemilik"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                        </div>

                        {{-- Row 2: Fotokopi + Toggle Wajib Asli + Keterangan --}}
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                            {{-- Fotokopi --}}
                            <div class="sm:col-span-4">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">
                                    Fotokopi
                                </label>
                                <input type="text"
                                       name="berkas[0][fotokopi]"
                                       value=""
                                       placeholder="Contoh: Fotokopi 2x"
                                       class="w-full px-3.5 py-2 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                            </div>

                            {{-- Toggle Wajib Asli --}}
                            <div class="sm:col-span-3 flex items-center gap-2 pb-2">
                                <input type="hidden"
                                       name="berkas[0][wajib_asli]"
                                       value="1"
                                       class="toggle-wajib-input">
                                <button type="button"
                                        onclick="toggleWajibAsli(this)"
                                        class="toggle-wajib-btn relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border transition-colors duration-200 ease-in-out focus:outline-none bg-[#0B4DA2] border-[#0B4DA2]">
                                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out translate-x-5"></span>
                                </button>
                                <span class="text-xs text-gray-700 font-medium select-none cursor-pointer"
                                      onclick="toggleWajibAsli(this.previousElementSibling)">
                                    Wajib asli
                                </span>
                            </div>

                            {{-- Keterangan (Opsional) --}}
                            <div class="sm:col-span-5">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">
                                    Keterangan (Opsional)
                                </label>
                                <input type="text"
                                       name="berkas[0][keterangan]"
                                       value=""
                                       placeholder="Contoh: Sesuai nama di STNK & BPKB"
                                       class="w-full px-3.5 py-2 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 3: Alur Langkah Pengurusan --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 space-y-5">
            {{-- Card Header with + Tambah Langkah --}}
            <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full border border-blue-200 bg-blue-50 text-[#1E70D0] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm sm:text-base font-bold text-[#0F2851]">
                        Alur Langkah Pengurusan (<span id="langkah-count">1</span>)
                    </h2>
                </div>

                <button type="button"
                        onclick="addLangkahRow()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full border border-[#1E70D0]/30 hover:border-[#1E70D0] bg-white hover:bg-blue-50 text-[#1E70D0] font-bold text-xs transition shadow-2xs cursor-pointer active:scale-95">
                    <span>+ Tambah Langkah</span>
                </button>
            </div>

            {{-- Langkah Items List --}}
            <div class="space-y-6" id="langkah-container">
                <div class="langkah-row flex items-start gap-4 p-3 rounded-2xl transition hover:bg-gray-50/70 border border-transparent hover:border-gray-200">
                    {{-- Left Column: Number Badge & Trash Icon --}}
                    <div class="flex flex-col items-center shrink-0 pt-1">
                        <div class="langkah-num w-6 h-6 rounded-full bg-[#0B4DA2] text-white font-bold text-xs flex items-center justify-center shadow-xs">
                            1
                        </div>
                        <button type="button"
                                onclick="removeLangkahRow(this)"
                                class="w-6 h-6 mt-2 rounded-full bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition shadow-2xs cursor-pointer"
                                title="Hapus langkah ini">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Right Column: Inputs --}}
                    <div class="flex-1 space-y-3 min-w-0">
                        {{-- Row 1: Judul Langkah & Kode Loket --}}
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                                    Nama Langkah & Kode Loket
                                </label>
                                <button type="button"
                                        onclick="removeLangkahRow(this)"
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer"
                                        title="Hapus langkah ini">
                                    <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                                <div class="sm:col-span-8">
                                    <input type="text"
                                           name="langkah[0][nama]"
                                           value=""
                                           placeholder="Contoh: Antrian MTC"
                                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                                </div>
                                <div class="sm:col-span-4">
                                    <input type="text"
                                           name="langkah[0][kode_loket]"
                                           value=""
                                           placeholder="Contoh: MTC"
                                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs uppercase">
                                </div>
                            </div>
                        </div>

                        {{-- Row 2: Keterangan Langkah --}}
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">
                                Keterangan
                            </label>
                            <input type="text"
                                   name="langkah[0][keterangan]"
                                   value=""
                                   placeholder="Contoh: Ambil nomor antrian di Mesin Antrian"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Actions (Right Aligned: Batal & Simpan Layanan) --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.layanan.index') }}"
               class="px-6 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-bold shadow-2xs transition active:scale-98">
                Batal
            </a>
            <button type="submit"
                    class="px-6 sm:px-7 py-2.5 rounded-xl bg-[#0B4DA2] hover:bg-blue-800 text-white text-xs sm:text-sm font-bold shadow-sm transition flex items-center gap-2 active:scale-98">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Simpan Layanan</span>
            </button>
        </div>
    </form>
</div>

<script>
function toggleWajibAsli(btn) {
    const parent = btn.closest('.flex');
    const input = parent.querySelector('.toggle-wajib-input');
    const knob = btn.querySelector('span');
    const isCurrentlyActive = input.value === '1';

    if (isCurrentlyActive) {
        input.value = '0';
        btn.classList.remove('bg-[#0B4DA2]', 'border-[#0B4DA2]');
        btn.classList.add('bg-[#E5E7EB]', 'border-gray-300');
        knob.classList.remove('translate-x-5');
        knob.classList.add('translate-x-0');
    } else {
        input.value = '1';
        btn.classList.remove('bg-[#E5E7EB]', 'border-gray-300');
        btn.classList.add('bg-[#0B4DA2]', 'border-[#0B4DA2]');
        knob.classList.remove('translate-x-0');
        knob.classList.add('translate-x-5');
    }
}

function updateBerkasNumbers() {
    const rows = document.querySelectorAll('#berkas-container .berkas-row');
    const countEl = document.getElementById('berkas-count');
    if (countEl) countEl.textContent = rows.length;

    rows.forEach((row, i) => {
        const numEl = row.querySelector('.berkas-num');
        if (numEl) numEl.textContent = i + 1;

        row.querySelectorAll('input').forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/berkas\[\d+\]/, `berkas[${i}]`);
            }
        });
    });
}

function removeBerkasRow(btn) {
    const row = btn.closest('.berkas-row');
    if (!row) return;

    const rows = document.querySelectorAll('#berkas-container .berkas-row');
    if (rows.length > 1) {
        row.remove();
        updateBerkasNumbers();
    } else {
        row.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
    }
}

function addBerkasRow() {
    const container = document.getElementById('berkas-container');
    const rows = container.querySelectorAll('.berkas-row');
    const nextIdx = rows.length;

    const template = `
        <div class="berkas-row flex items-start gap-4 p-3 rounded-2xl transition hover:bg-gray-50/70 border border-transparent hover:border-gray-200">
            <div class="flex flex-col items-center shrink-0 pt-1">
                <div class="berkas-num w-6 h-6 rounded-full bg-[#EBF3FC] text-[#1E70D0] font-bold text-xs flex items-center justify-center shadow-2xs">
                    ${nextIdx + 1}
                </div>
                <button type="button"
                        onclick="removeBerkasRow(this)"
                        class="w-6 h-6 mt-2 rounded-full bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition shadow-2xs cursor-pointer"
                        title="Hapus berkas ini">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 space-y-3 min-w-0">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                            Nama Berkas
                        </label>
                        <button type="button"
                                onclick="removeBerkasRow(this)"
                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer"
                                title="Hapus berkas ini">
                            <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </div>
                    <input type="text"
                           name="berkas[${nextIdx}][nama]"
                           placeholder="Contoh: KTP Asli Pemilik"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                    <div class="sm:col-span-4">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">
                            Fotokopi
                        </label>
                        <input type="text"
                               name="berkas[${nextIdx}][fotokopi]"
                               placeholder="Contoh: Fotokopi 2x"
                               class="w-full px-3.5 py-2 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                    </div>
                    <div class="sm:col-span-3 flex items-center gap-2 pb-2">
                        <input type="hidden"
                               name="berkas[${nextIdx}][wajib_asli]"
                               value="1"
                               class="toggle-wajib-input">
                        <button type="button"
                                onclick="toggleWajibAsli(this)"
                                class="toggle-wajib-btn relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border transition-colors duration-200 ease-in-out focus:outline-none bg-[#0B4DA2] border-[#0B4DA2]">
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out translate-x-5"></span>
                        </button>
                        <span class="text-xs text-gray-700 font-medium select-none cursor-pointer"
                              onclick="toggleWajibAsli(this.previousElementSibling)">
                            Wajib asli
                        </span>
                    </div>
                    <div class="sm:col-span-5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">
                            Keterangan (Opsional)
                        </label>
                        <input type="text"
                               name="berkas[${nextIdx}][keterangan]"
                               placeholder="Contoh: Gesek nomor rangka & mesin"
                               class="w-full px-3.5 py-2 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                    </div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', template);
    updateBerkasNumbers();
}

function updateLangkahNumbers() {
    const rows = document.querySelectorAll('#langkah-container .langkah-row');
    const countEl = document.getElementById('langkah-count');
    if (countEl) countEl.textContent = rows.length;

    rows.forEach((row, i) => {
        const numEl = row.querySelector('.langkah-num');
        if (numEl) numEl.textContent = i + 1;

        row.querySelectorAll('input').forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/langkah\[\d+\]/, `langkah[${i}]`);
            }
        });
    });
}

function removeLangkahRow(btn) {
    const row = btn.closest('.langkah-row');
    if (!row) return;

    const rows = document.querySelectorAll('#langkah-container .langkah-row');
    if (rows.length > 1) {
        row.remove();
        updateLangkahNumbers();
    } else {
        row.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
    }
}

function addLangkahRow() {
    const container = document.getElementById('langkah-container');
    const rows = container.querySelectorAll('.langkah-row');
    const nextIdx = rows.length;

    const template = `
        <div class="langkah-row flex items-start gap-4 p-3 rounded-2xl transition hover:bg-gray-50/70 border border-transparent hover:border-gray-200">
            <div class="flex flex-col items-center shrink-0 pt-1">
                <div class="langkah-num w-6 h-6 rounded-full bg-[#0B4DA2] text-white font-bold text-xs flex items-center justify-center shadow-xs">
                    ${nextIdx + 1}
                </div>
                <button type="button"
                        onclick="removeLangkahRow(this)"
                        class="w-6 h-6 mt-2 rounded-full bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition shadow-2xs cursor-pointer"
                        title="Hapus langkah ini">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 space-y-3 min-w-0">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                            Nama Langkah & Kode Loket
                        </label>
                        <button type="button"
                                onclick="removeLangkahRow(this)"
                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer"
                                title="Hapus langkah ini">
                            <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                        <div class="sm:col-span-8">
                            <input type="text"
                                   name="langkah[${nextIdx}][nama]"
                                   placeholder="Contoh: Antrian MTC"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                        </div>
                        <div class="sm:col-span-4">
                            <input type="text"
                                   name="langkah[${nextIdx}][kode_loket]"
                                   placeholder="Contoh: MTC"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs uppercase">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">
                        Keterangan
                    </label>
                    <input type="text"
                           name="langkah[${nextIdx}][keterangan]"
                           placeholder="Contoh: Ambil nomor antrian di Mesin Antrian"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition shadow-2xs">
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', template);
    updateLangkahNumbers();
}
</script>
@endsection

