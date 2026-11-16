@extends('layouts.public')

@section('title', 'Kritik & Saran - SiDamar SAMSAT Manyar')

@section('content')
<div class="bg-[#EEF5FB] min-h-[calc(100vh-180px)] py-8 sm:py-12">

    {{-- Main Container --}}
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Back Navigation --}}
        <div class="mb-5">
            <a href="{{ route('beranda') }}"
               class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-gray-600 hover:text-[#0B4DA2] transition group">
                <svg class="w-4 h-4 text-gray-500 group-hover:text-[#0B4DA2] transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        {{-- Page Header --}}
        <div class="mb-6">
            <div class="inline-flex items-center px-4 py-1 rounded-full bg-[#DCEAF8] text-[#1E70D0] text-xs font-extrabold uppercase tracking-widest mb-3">
                KRITIK &amp; SARAN
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#0F2851] tracking-tight">
                Sampaikan Pendapat Anda
            </h1>
            <p class="text-sm sm:text-base text-gray-500 mt-2">
                Masukan Anda sangat berarti untuk meningkatkan kualitas pelayanan KB SAMSAT Surabaya Timur.
            </p>
        </div>

        {{-- Security Banner --}}
        <div class="mb-5 p-3 px-4 rounded-xl bg-[#E8F8EE] border border-[#B9E9CA] flex items-center gap-2.5 text-xs text-[#166534] shadow-sm">
            <svg class="w-4 h-4 text-[#16A34A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="font-medium">Protected by XSS &amp; SQL-Injection Anti-Spam Filter · Data Anda aman &amp; tidak dibagikan</span>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm overflow-hidden">
            {{-- Card Label --}}
            <div class="px-6 sm:px-10 py-4 border-b border-gray-100">
                <span class="text-[11px] sm:text-xs font-bold tracking-widest text-gray-400 uppercase">
                    PORTAL MASUKAN WAJIB PAJAK · TANPA LOGIN · TANPA NIK
                </span>
            </div>

            <div class="px-6 sm:px-10 py-8">

                {{-- Server-side Validation Error Banner (Fallback) --}}
                @if($errors->any())
                    <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-start gap-2.5">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Client-side Dynamic Error Box --}}
                <div id="form-error-box" class="hidden mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-start gap-2.5">
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="form-error-text"></span>
                </div>

                {{-- THE FORM --}}
                <form id="form-masukan"
                      method="POST"
                      action="{{ route('masukan.store') }}"
                      onsubmit="handleMasukanSubmit(event)"
                      class="space-y-6">
                    @csrf

                    {{-- Row 1: Nama & No. HP/Email matching Mockup --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Nama (Opsional) --}}
                        <div>
                            <label for="nama" class="block text-xs sm:text-sm font-semibold text-[#0F2851] mb-1.5">
                                Nama <span class="text-gray-400 font-normal">[opsional]</span>
                            </label>
                            <input type="text" id="nama" name="nama"
                                   value="{{ old('nama') }}"
                                   placeholder="Nama lengkap Anda"
                                   maxlength="100"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-800 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition bg-[#FBFDFE]">
                        </div>

                        {{-- No. HP / Email (Opsional) --}}
                        <div>
                            <label for="kontak" class="block text-xs sm:text-sm font-semibold text-[#0F2851] mb-1.5">
                                No. HP / Email <span class="text-gray-400 font-normal">[opsional]</span>
                            </label>
                            <input type="text" id="kontak" name="kontak"
                                   value="{{ old('kontak') }}"
                                   placeholder="Untuk tindak lanjut"
                                   maxlength="150"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-800 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition bg-[#FBFDFE]">
                        </div>
                    </div>

                    {{-- Penilaian Bintang --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-[#0F2851] mb-2">
                            Penilaian Layanan <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="flex items-center gap-1.5">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        id="star-btn-{{ $i }}"
                                        onclick="setRating({{ $i }})"
                                        onmouseenter="hoverRating({{ $i }})"
                                        onmouseleave="hoverRating(0)"
                                        class="p-1 focus:outline-none rounded transition-transform hover:scale-110 cursor-pointer">
                                    <svg id="star-{{ $i }}" class="w-8 h-8 text-gray-200 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                </button>
                            @endfor
                            <span id="rating-label" class="hidden text-xs font-bold text-amber-500 ml-1.5"></span>
                        </div>
                        <input type="hidden" id="rating-input" name="rating" value="5">
                    </div>

                    {{-- Kritik --}}
                    <div>
                        <label for="kritik" class="block text-xs sm:text-sm font-semibold text-[#0F2851] mb-1.5">
                            Kritik <span class="text-gray-400 font-normal">— apa yang perlu diperbaiki?</span>
                        </label>
                        <textarea id="kritik" name="kritik" rows="4" maxlength="2000"
                                  placeholder="Sampaikan keluhan atau kritik Anda terhadap pelayanan SAMSAT..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 text-gray-800 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition bg-[#FBFDFE] resize-y">{{ old('kritik') }}</textarea>
                    </div>

                    {{-- Saran --}}
                    <div>
                        <label for="saran" class="block text-xs sm:text-sm font-semibold text-[#0F2851] mb-1.5">
                            Saran <span class="text-gray-400 font-normal">— apa yang bisa ditingkatkan?</span>
                        </label>
                        <textarea id="saran" name="saran" rows="4" maxlength="2000"
                                  placeholder="Berikan saran konstruktif untuk perbaikan layanan..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 text-gray-800 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition bg-[#FBFDFE] resize-y">{{ old('saran') }}</textarea>
                    </div>

                    {{-- Submit Row --}}
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400 italic self-start sm:self-center">
                            * Isi minimal satu dari Kritik atau Saran
                        </span>
                        <button type="submit"
                                id="btn-submit-masukan"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#0B4DA2] hover:bg-blue-800 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold text-sm px-8 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 active:scale-95 cursor-pointer">
                            <svg class="w-4 h-4 rotate-45 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <span>Kirim Masukan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =====================================================
         POP-UP MODAL — Sembunyi secara default (display: none)
         HANYA muncul saat pemanggilan openSuccessModal() setelah data terkirim
         ===================================================== --}}
    <div id="modal-success"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm hidden"
         style="display: none;">

        <div class="bg-white rounded-3xl p-8 sm:p-10 max-w-sm sm:max-w-md w-full shadow-2xl text-center border border-gray-100 transform transition-all duration-200">

            {{-- Green Check Icon matching Mockup --}}
            <div class="w-16 h-16 rounded-full bg-[#E8F8EE] border-2 border-[#B9E9CA] text-[#16A34A] flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h3 class="text-2xl font-extrabold text-[#0F2851] tracking-tight">Masukan Terkirim!</h3>
            <p class="text-sm text-gray-500 mt-2.5 leading-relaxed max-w-xs mx-auto">
                Terima kasih. Masukan Anda telah diterima dan akan ditinjau oleh tim KB SAMSAT Surabaya Timur.
            </p>

            <div class="grid grid-cols-2 gap-3 mt-7">
                {{-- Kirim Lagi: tutup modal, form sudah kosong --}}
                <button type="button"
                        onclick="closeSuccessModal()"
                        class="w-full py-3 px-4 rounded-xl border-2 border-gray-200 hover:border-gray-300 text-gray-700 hover:bg-gray-50 font-bold text-sm transition-colors flex items-center justify-center cursor-pointer">
                    Kirim Lagi
                </button>
                <a href="{{ route('beranda') }}"
                   class="w-full py-3 px-4 rounded-xl bg-[#0B4DA2] hover:bg-blue-800 text-white font-bold text-sm transition-colors flex items-center justify-center shadow-md">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let currentRating = 5;

function setRating(val) {
    currentRating = val;
    document.getElementById('rating-input').value = val;
    renderStars(val);
    const label = document.getElementById('rating-label');
    if (label) {
        label.textContent = val + ' / 5 Bintang';
        label.classList.remove('hidden');
    }
}

function hoverRating(val) {
    renderStars(val > 0 ? val : currentRating);
}

function renderStars(activeCount) {
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById('star-' + i);
        if (star) {
            if (i <= activeCount) {
                star.classList.remove('text-gray-200');
                star.classList.add('text-amber-400');
            } else {
                star.classList.remove('text-amber-400');
                star.classList.add('text-gray-200');
            }
        }
    }
}

function resetRatingStars() {
    currentRating = 5;
    document.getElementById('rating-input').value = 5;
    renderStars(0);
    const label = document.getElementById('rating-label');
    if (label) {
        label.classList.add('hidden');
    }
}

function openSuccessModal() {
    const modal = document.getElementById('modal-success');
    if (modal) {
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
    }
}

function closeSuccessModal() {
    const modal = document.getElementById('modal-success');
    if (modal) {
        modal.classList.add('hidden');
        modal.style.display = 'none';
    }
}

async function handleMasukanSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const btnSubmit = document.getElementById('btn-submit-masukan');
    const errorBox = document.getElementById('form-error-box');
    const errorText = document.getElementById('form-error-text');

    if (errorBox) errorBox.classList.add('hidden');

    const kritik = (form.querySelector('[name="kritik"]')?.value || '').trim();
    const saran  = (form.querySelector('[name="saran"]')?.value || '').trim();

    if (!kritik && !saran) {
        if (errorBox && errorText) {
            errorText.textContent = 'Mohon isi minimal salah satu dari Kritik atau Saran.';
            errorBox.classList.remove('hidden');
        }
        return;
    }

    if (btnSubmit) {
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span>Mengirim...</span>
        `;
    }

    try {
        const formData = new FormData(form);
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });

        const result = await response.json();

        if (response.ok && result.success) {
            form.reset();
            resetRatingStars();
            openSuccessModal();
        } else {
            let msg = 'Terjadi kesalahan saat mengirim masukan.';
            if (result.errors) {
                msg = Object.values(result.errors).flat().join(' ');
            } else if (result.message) {
                msg = result.message;
            }
            if (errorBox && errorText) {
                errorText.textContent = msg;
                errorBox.classList.remove('hidden');
            }
        }
    } catch (err) {
        if (errorBox && errorText) {
            errorText.textContent = 'Gagal menghubungi server. Periksa koneksi Anda.';
            errorBox.classList.remove('hidden');
        }
    } finally {
        if (btnSubmit) {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = `
                <svg class="w-4 h-4 rotate-45 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                <span>Kirim Masukan</span>
            `;
        }
    }
}
</script>
@endsection
