@props(['layanan'])

@php
    $mapData = [
        'nama' => $layanan->nama,
        'langkah' => $layanan->langkah->values(),
        'berkas' => $layanan->berkas->values(),
    ];
@endphp

<div x-data="serviceMap" data-service="{{ json_encode($mapData) }}" data-plan-url="{{ asset('denah-samsat.html') }}"
     x-on:open-service-map.window="openFromEvent($event)">
    <dialog x-ref="dialog" class="service-map-dialog" aria-labelledby="service-map-title"
            x-on:close="cleanup()" x-on:click="closeFromBackdrop($event)">
        <header class="service-map-header">
            <div>
                <p class="service-map-eyebrow">PANDUAN KUNJUNGAN</p>
                <h2 id="service-map-title">Alur Layanan di Denah</h2>
                <p>Ikuti nomor tahap untuk mengetahui tujuan berikutnya.</p>
            </div>
            <button type="button" class="service-map-close" x-on:click="closeMap()" aria-label="Tutup denah" autofocus>×</button>
        </header>

        <div class="service-map-layout">
            <nav class="service-map-step-list" aria-label="Daftar lengkap langkah layanan">
                <h3>Urutan layanan</h3>
                <p>Mulai dari langkah 1. Pilih tahap untuk melihat rinciannya.</p>
                <ol x-ref="steps">
                    <template x-for="(step, index) in steps" :key="index">
                        <li>
                            <button type="button" :data-step="index" x-on:click="selectStep(index)"
                                    :aria-current="activeIndex === index ? 'step' : null"
                                    :class="{ 'is-active': activeIndex === index }">
                                <span class="service-map-number" x-text="index + 1"></span>
                                <span>
                                    <strong x-text="step.teks"></strong>
                                    <small x-text="step.kode_loket || 'Loket belum tercatat'"></small>
                                </span>
                                <span class="service-map-step-arrow" aria-hidden="true">↗</span>
                            </button>
                        </li>
                    </template>
                </ol>
            </nav>

            <div class="service-map-main">
                <div class="service-map-heading">
                    <h3 aria-live="polite" aria-atomic="true">
                        <span x-text="service.nama"></span> · Langkah <span x-text="activeIndex + 1"></span> dari <span x-text="steps.length"></span>
                    </h3>
                    <span class="service-map-mode" x-text="mode"></span>
                </div>

                <div class="service-map-stage" :aria-busy="loading">
                    <div class="service-map-canvas" x-ref="canvas"></div>
                    <div class="service-map-pins" x-ref="pins">
                        <template x-for="location in locations" :key="location.key">
                            <div class="service-map-pin" data-map-pin :class="{ 'is-active': currentLocation.key === location.key }">
                                <span class="service-map-pin-name" x-text="location.name"></span>
                                <div class="service-map-pin-buttons">
                                    <template x-for="index in location.steps" :key="index">
                                        <button type="button" x-on:click="selectStep(index)"
                                                :aria-label="'Langkah ' + (index + 1) + ', ' + steps[index].teks"
                                                :aria-pressed="activeIndex === index"
                                                :class="{ 'is-active': activeIndex === index }" x-text="index + 1"></button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="service-map-tools" role="group" aria-label="Kontrol tampilan denah">
                        <button type="button" x-on:click="zoom(1.3)" aria-label="Perbesar denah">+</button>
                        <button type="button" x-on:click="zoom(1 / 1.3)" aria-label="Perkecil denah">−</button>
                        <button type="button" x-on:click="overview()">Lihat Seluruh Rute</button>
                    </div>
                    <p class="service-map-loading" x-show="loading">Memuat denah…</p>
                </div>

                <div class="service-map-caption">
                    <p><strong>Ilustrasi alur layanan</strong> · Garis berpanah menghubungkan urutan tahap. Posisi area mengikuti aset denah proyek.</p>
                    <p>Angka pada penanda menunjukkan tahap kunjungan. Tahap tanpa posisi pada aset ditampilkan pada bagian terpisah.</p>
                    <p x-show="mode === '3D'">Geser untuk rotasi terbatas. Cubit atau gunakan tombol + dan − untuk zoom.</p>
                    <p x-show="status" x-text="status" role="status"></p>
                    <details x-show="places.length" class="service-map-area-key">
                        <summary>Nama area pada denah</summary>
                        <ul>
                            <template x-for="place in places" :key="place.id">
                                <li x-text="place.name"></li>
                            </template>
                        </ul>
                    </details>
                </div>

                <section class="service-map-current" aria-label="Rincian langkah aktif">
                    <div class="service-map-current-title">
                        <span class="service-map-number" x-text="activeIndex + 1"></span>
                        <div>
                            <p x-text="activeIndex === 0 ? 'Mulai di sini' : 'Tujuan tahap ini'"></p>
                            <h4 x-text="currentStep.teks"></h4>
                        </div>
                        <span class="service-map-code" x-show="currentStep.kode_loket" x-text="currentStep.kode_loket"></span>
                    </div>
                    <p class="service-map-activity" x-text="currentStep.keterangan || currentStep.teks"></p>
                    <p class="service-map-location" x-text="currentLocation.mapped ? 'Lokasi pada denah · ' + currentLocation.name : 'Posisi loket belum tercatat pada aset denah. Konfirmasikan lokasi kepada petugas.'"></p>
                    <details class="service-map-documents">
                        <summary>Berkas yang perlu disiapkan untuk <span x-text="service.nama"></span> (<span x-text="service.berkas.length"></span>)</summary>
                        <p>Persyaratan umum layanan. Rincian berkas per tahap belum tersedia.</p>
                        <ul>
                            <template x-for="(document, index) in service.berkas" :key="index">
                                <li>
                                    <strong x-text="document.teks"></strong>
                                    <span x-show="document.wajib_asli" class="service-map-document-badge">Asli</span>
                                    <span x-show="document.fotokopi" x-text="document.fotokopi" class="service-map-document-badge"></span>
                                    <small x-show="document.keterangan" x-text="document.keterangan"></small>
                                </li>
                            </template>
                        </ul>
                        <p x-show="!service.berkas.length">Belum ada persyaratan berkas yang tercatat.</p>
                    </details>
                </section>

                <div class="service-map-navigation">
                    <button type="button" x-on:click="selectStep(activeIndex - 1)" :disabled="activeIndex === 0">← Sebelumnya</button>
                    <span x-text="(activeIndex + 1) + ' / ' + steps.length"></span>
                    <button type="button" x-on:click="selectStep(activeIndex + 1)" :disabled="activeIndex === steps.length - 1">Berikutnya →</button>
                </div>
            </div>
        </div>
    </dialog>
</div>
