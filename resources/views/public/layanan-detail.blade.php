@extends('layouts.public')

@section('title', $layanan->nama . ' - Panduan Layanan SAMSAT Manyar')

@section('content')
@php
    // Service-specific metadata dictionary matching Figma mockup design
    $serviceMeta = [
        'lapor-jual' => [
            'kategori_label' => 'PEMBLOKIRAN & PELAPORAN',
            'icon' => 'ban',
            'subtitle' => 'Blokir Lapor Jual ERI & Layanan Progresif',
            'loket' => [
                ['kode' => 'MTC', 'nama' => 'Mesin Antrean MTC', 'deskripsi' => 'Ambil nomor antrian di Mesin Antrian Lobby', 'x' => '18%', 'y' => '35%'],
                ['kode' => 'VR', 'nama' => 'Loket Keabsahan VR', 'deskripsi' => 'Verifikasi keabsahan data kepemilikan lama', 'x' => '32%', 'y' => '65%'],
                ['kode' => 'FORM', 'nama' => 'Loket Formulir Lapor Jual', 'deskripsi' => 'Pengambilan & pengisian formulir pernyataan', 'x' => '48%', 'y' => '65%'],
                ['kode' => 'ERI', 'nama' => 'Loket ERI Pemblokiran', 'deskripsi' => 'Proses pemblokiran data kendaraan di sistem ERI', 'x' => '65%', 'y' => '45%'],
                ['kode' => 'TKL', 'nama' => 'Verifikasi & Validasi Petugas', 'deskripsi' => 'Pengecekan akhir berkas oleh petugas verifikator', 'x' => '75%', 'y' => '45%'],
                ['kode' => 'PLT', 'nama' => 'Loket Penyerahan Bukti', 'deskripsi' => 'Penerimaan tanda bukti blokir lapor jual resmi', 'x' => '85%', 'y' => '65%'],
            ],
            'faqs' => [
                [
                    'q' => 'Apakah ada biaya untuk lapor jual kendaraan?',
                    'a' => 'Tidak ada biaya (GRATIS). Pelaporan jual kendaraan bermotor dan pemblokiran di SAMSAT Manyar tidak dipungut biaya retribusi apapun.'
                ],
                [
                    'q' => 'Bagaimana jika BPKB masih dalam agunan / leasing?',
                    'a' => 'Cukup bawa surat keterangan resmi dari leasing yang menyatakan kendaraan sedang dalam agunan beserta fotokopi legalisir BPKB.'
                ],
                [
                    'q' => 'Apakah pelaporan lapor jual bisa diwakilkan?',
                    'a' => 'Bisa diwakilkan dengan menyertakan Surat Kuasa bermaterai Rp 10.000 asli ditandatangani pemilik sesuai KTP serta fotokopi KTP penerima kuasa.'
                ],
                [
                    'q' => 'Berapa lama proses pemblokiran aktif di sistem?',
                    'a' => 'Pemblokiran langsung diproses saat berkas diverifikasi di loket ERI dan aktif seketika pada database ERI Korlantas & Bapenda Jatim.'
                ]
            ]
        ],
        'mutasi-keluar' => [
            'kategori_label' => 'MUTASI KELUAR DAERAH',
            'icon' => 'logout',
            'subtitle' => 'Layanan Pindah Daerah / Fiskal Antardaerah',
            'loket' => [
                ['kode' => 'FISIK', 'nama' => 'Loket Cek Fisik', 'deskripsi' => 'Gesek nomor rangka & mesin di area cek fisik', 'x' => '80%', 'y' => '78%'],
                ['kode' => 'MTC', 'nama' => 'Mesin Antrean', 'deskripsi' => 'Ambil nomor antrian mutasi keluar', 'x' => '18%', 'y' => '35%'],
                ['kode' => 'FISKAL', 'nama' => 'Loket Fiskal Antardaerah', 'deskripsi' => 'Penerbitan surat keterangan fiskal antardaerah', 'x' => '35%', 'y' => '65%'],
                ['kode' => 'KSR', 'nama' => 'Kasir PNBP Cabut Berkas', 'deskripsi' => 'Pembayaran PNBP penerbitan surat mutasi keluar', 'x' => '65%', 'y' => '45%'],
                ['kode' => 'ARSIP', 'nama' => 'Loket Pengambilan Berkas', 'deskripsi' => 'Pengambilan bundel berkas cabutan induk', 'x' => '80%', 'y' => '50%'],
            ],
            'faqs' => [
                [
                    'q' => 'Berapa lama proses pencabutan berkas mutasi keluar?',
                    'a' => 'Pencabutan berkas induk umumnya membutuhkan waktu 1–3 hari kerja untuk verifikasi berkas dari gudang arsip.'
                ],
                [
                    'q' => 'Apakah fisik kendaraan harus dibawa saat mutasi keluar?',
                    'a' => 'Ya, kendaraan wajib dibawa ke SAMSAT Manyar untuk dilakukan cek fisik gesek nomor rangka dan nomor mesin.'
                ],
                [
                    'q' => 'Bagaimana jika pajak kendaraan masih ada tunggakan?',
                    'a' => 'Seluruh tunggakan pajak PKB & SWDKLLJ tahun berjalan wajib dilunasi terlebih dahulu di loket kasir sebelum fiskal diterbitkan.'
                ]
            ]
        ],
        'mutasi-masuk' => [
            'kategori_label' => 'MUTASI MASUK DAERAH',
            'icon' => 'login',
            'subtitle' => 'Pendaftaran Kendaraan Masuk dari Luar Daerah ke SAMSAT Manyar',
            'loket' => [
                ['kode' => 'FISIK', 'nama' => 'Cek Fisik Samsat Manyar', 'deskripsi' => 'Pengecekan fisik kendaraan kedatangan mutasi', 'x' => '80%', 'y' => '78%'],
                ['kode' => 'MTC', 'nama' => 'Mesin Antrean', 'deskripsi' => 'Ambil tiket antrian pendaftaran mutasi masuk', 'x' => '18%', 'y' => '35%'],
                ['kode' => 'REG', 'nama' => 'Loket Pendaftaran Berkas', 'deskripsi' => 'Penyerahan berkas cabutan dari SAMSAT asal', 'x' => '35%', 'y' => '65%'],
                ['kode' => 'KSR', 'nama' => 'Kasir Pembayaran PKB & BBN', 'deskripsi' => 'Pembayaran PKB Jawa Timur dan biaya cetak dokumen', 'x' => '65%', 'y' => '45%'],
                ['kode' => 'PLT', 'nama' => 'Loket Penyerahan STNK & Plat', 'deskripsi' => 'Pengambilan STNK baru dan plat nomor L', 'x' => '85%', 'y' => '65%'],
            ],
            'faqs' => [
                [
                    'q' => 'Apakah berkas cabutan dari Samsat asal memiliki masa berlaku?',
                    'a' => 'Ya, surat keterangan mutasi keluar umumnya memiliki batas waktu 30 hari. Segera daftarkan di Samsat Manyar sebelum lewat masa berlaku.'
                ],
                [
                    'q' => 'Apakah langsung mendapatkan plat nomor baru kota Surabaya (plat L)?',
                    'a' => 'Ya, setelah verifikasi dan pelunasan di kasir, STNK baru dan plat nomor L akan langsung diproses.'
                ]
            ]
        ],
        'kendaraan-baru' => [
            'kategori_label' => 'KENDARAAN BARU',
            'icon' => 'plus',
            'subtitle' => 'Pendaftaran Faktur Dealer BPKB / STNK Kendaraan Baru',
            'loket' => [
                ['kode' => 'FISIK', 'nama' => 'Cek Fisik Kendaraan Baru', 'deskripsi' => 'Gesek nomor rangka dan mesin dealer', 'x' => '80%', 'y' => '78%'],
                ['kode' => 'REG', 'nama' => 'Loket Pendaftaran Faktur', 'deskripsi' => 'Pemeriksaan faktur, sertifikat NIK & berkas dealer', 'x' => '35%', 'y' => '65%'],
                ['kode' => 'BBN', 'nama' => 'Loket BBN-KB I', 'deskripsi' => 'Penetapan nilai Bea Balik Nama Kendaraan Baru', 'x' => '50%', 'y' => '65%'],
                ['kode' => 'KSR', 'nama' => 'Kasir Pembayaran', 'deskripsi' => 'Pembayaran BBN-KB, PKB tahun pertama, SWDKLLJ & PNBP', 'x' => '65%', 'y' => '45%'],
                ['kode' => 'TNKB', 'nama' => 'Loket Cetak STNK & Plat TNKB', 'deskripsi' => 'Penerbitan STNK dan pencetakan plat nomor baru', 'x' => '85%', 'y' => '65%'],
            ],
            'faqs' => [
                [
                    'q' => 'Berapa lama proses pembuatan STNK kendaraan baru?',
                    'a' => 'Umumnya proses pendaftaran hingga STNK terbit memakan waktu 1–3 hari kerja jika seluruh faktur dari APM/dealer telah lengkap.'
                ],
                [
                    'q' => 'Apakah BPKB langsung diserahkan bersamaan dengan STNK?',
                    'a' => 'STNK dan Plat Nomor terbit lebih dulu. BPKB asli diterbitkan oleh Ditlantas Polda Jatim dan dapat diambil di loket BPKB sesuai jadwal dealer/Samsat.'
                ]
            ]
        ],
        'stnk-duplikat' => [
            'kategori_label' => 'DUPLIKAT STNK',
            'icon' => 'document',
            'subtitle' => 'Penerbitan STNK Pengganti karena Hilang atau Rusak',
            'loket' => [
                ['kode' => 'FISIK', 'nama' => 'Cek Fisik Kendaraan', 'deskripsi' => 'Wajib gesek nomor rangka & mesin untuk konfirmasi keaslian', 'x' => '80%', 'y' => '78%'],
                ['kode' => 'MTC', 'nama' => 'Mesin Antrean', 'deskripsi' => 'Ambil tiket antrian duplikat STNK', 'x' => '18%', 'y' => '35%'],
                ['kode' => 'LAPOR', 'nama' => 'Loket Verifikasi Laporan Hilang', 'deskripsi' => 'Pengecekan surat kehilangan kepolisian & iklan koran/radio', 'x' => '40%', 'y' => '65%'],
                ['kode' => 'KSR', 'nama' => 'Kasir Biaya PNBP STNK', 'deskripsi' => 'Pembayaran biaya cetak STNK duplikat resmi', 'x' => '65%', 'y' => '45%'],
                ['kode' => 'PLT', 'nama' => 'Loket Penyerahan STNK Duplikat', 'deskripsi' => 'Pengambilan lembar STNK pengganti resmi', 'x' => '85%', 'y' => '65%'],
            ],
            'faqs' => [
                [
                    'q' => 'Apa syarat utama jika STNK hilang?',
                    'a' => 'Surat laporan kehilangan dari Polsek/Polres setempat, KTP asli pemilik, BPKB asli (atau surat keterangan leasing jika agunan), dan bukti publikasi iklan media.'
                ],
                [
                    'q' => 'Bagaimana jika STNK hanya rusak atau robek?',
                    'a' => 'Bawa sisa fisik STNK yang rusak beserta BPKB & KTP asli. Tidak perlu surat kehilangan polisi jika fisik STNK masih dapat diverifikasi nomor serinya.'
                ]
            ]
        ],
        'perpanjangan-5-tahunan' => [
            'kategori_label' => 'PERPANJANGAN 5 TAHUN',
            'icon' => 'calendar',
            'subtitle' => 'Pajak 5 Tahunan, Ganti Plat Nomor (TNKB) & Pindah Alamat',
            'loket' => [
                ['kode' => 'FISIK', 'nama' => 'Area Cek Fisik & Legalisir', 'deskripsi' => 'Cek fisik gesek nomor mesin & rangka di area timur', 'x' => '80%', 'y' => '78%'],
                ['kode' => 'MTC', 'nama' => 'Mesin Antrean Utama', 'deskripsi' => 'Ambil nomor antrian perpanjangan 5 tahun', 'x' => '18%', 'y' => '35%'],
                ['kode' => 'REG', 'nama' => 'Loket Pendaftaran 5 Tahun', 'deskripsi' => 'Pemeriksaan berkas KTP, STNK, BPKB & hasil cek fisik', 'x' => '35%', 'y' => '65%'],
                ['kode' => 'KSR', 'nama' => 'Kasir Pembayaran PKB & TNKB', 'deskripsi' => 'Pembayaran PKB 5 tahunan + PNBP STNK & PNBP Plat TNKB', 'x' => '65%', 'y' => '45%'],
                ['kode' => 'CETAK', 'nama' => 'Loket Penyerahan STNK', 'deskripsi' => 'Pengambilan lembar STNK dan notice pajak baru', 'x' => '75%', 'y' => '65%'],
                ['kode' => 'TNKB', 'nama' => 'Workshop Cetak Plat TNKB', 'deskripsi' => 'Pengambilan sepasang plat nomor kaleng baru', 'x' => '85%', 'y' => '65%'],
            ],
            'faqs' => [
                [
                    'q' => 'Apakah kendaraan harus dibawa untuk pajak 5 tahunan?',
                    'a' => 'Wajib dibawa, karena perpanjangan 5 tahunan memerlukan cek fisik kendaraan (gesek nomor rangka & mesin) secara langsung di SAMSAT Manyar.'
                ],
                [
                    'q' => 'Apakah pengurusan pajak 5 tahunan bisa diwakilkan?',
                    'a' => 'Bisa diwakilkan dengan menyertakan Surat Kuasa bermaterai Rp 10.000 asli, fotokopi KTP penerima kuasa, serta KTP asli pemilik kendaraan.'
                ],
                [
                    'q' => 'Berapa lama proses cetak STNK dan Plat Nomor baru?',
                    'a' => 'Setelah pembayaran di kasir, cetak STNK membutuhkan waktu sekitar 20–30 menit, dan plat nomor baru dapat diambil di hari yang sama.'
                ]
            ]
        ],
        'bbn-intern' => [
            'kategori_label' => 'BEA BALIK NAMA (BBN INTERN)',
            'icon' => 'swap',
            'subtitle' => 'Balik Nama Kendaraan Bermotor dalam Wilayah Surabaya Timur',
            'loket' => [
                ['kode' => 'FISIK', 'nama' => 'Loket Cek Fisik Kendaraan', 'deskripsi' => 'Pemeriksaan keaslian nomor rangka & nomor mesin', 'x' => '80%', 'y' => '78%'],
                ['kode' => 'MTC', 'nama' => 'Mesin Antrean', 'deskripsi' => 'Ambil tiket antrian pendaftaran balik nama', 'x' => '18%', 'y' => '35%'],
                ['kode' => 'BBN', 'nama' => 'Loket Verifikasi Balik Nama', 'deskripsi' => 'Validasi kwitansi jual beli bermaterai & KTP pembeli', 'x' => '40%', 'y' => '65%'],
                ['kode' => 'KSR', 'nama' => 'Kasir Pembayaran BBN-KB', 'deskripsi' => 'Pelunasan Bea Balik Nama, PKB, SWDKLLJ & PNBP', 'x' => '65%', 'y' => '45%'],
                ['kode' => 'PLT', 'nama' => 'Loket Penyerahan Dokumen', 'deskripsi' => 'Pengambilan STNK baru atas nama pemilik baru', 'x' => '85%', 'y' => '65%'],
            ],
            'faqs' => [
                [
                    'q' => 'Apakah perlu membawa KTP pemilik lama saat balik nama?',
                    'a' => 'Tidak wajib membawa KTP asli pemilik lama, cukup kwitansi pembelian bermaterai Rp 10.000 asli dari pemilik lama ke pemilik baru dan KTP asli pemilik baru.'
                ],
                [
                    'q' => 'Kapan BPKB atas nama baru dapat diambil?',
                    'a' => 'STNK terbit di hari yang sama. Untuk buku BPKB atas nama baru, proses di bagian BPKB Polda Jatim memakan waktu sekitar 1–2 minggu.'
                ]
            ]
        ],
    ];

    $meta = $serviceMeta[$layanan->slug] ?? [
        'kategori_label' => strtoupper($layanan->kategori->nama ?? 'LAYANAN SAMSAT'),
        'icon' => 'document',
        'subtitle' => $layanan->deskripsi ?? 'Informasi persyaratan dan alur layanan resmi KB SAMSAT Surabaya Timur',
        'loket' => [
            ['kode' => 'MTC', 'nama' => 'Mesin Antrean', 'deskripsi' => 'Ambil tiket antrian di lobby', 'x' => '18%', 'y' => '35%'],
            ['kode' => 'REG', 'nama' => 'Loket Pendaftaran', 'deskripsi' => 'Pemeriksaan kelengkapan berkas', 'x' => '35%', 'y' => '65%'],
            ['kode' => 'KSR', 'nama' => 'Loket Kasir', 'deskripsi' => 'Pembayaran tagihan resmi', 'x' => '65%', 'y' => '45%'],
            ['kode' => 'PLT', 'nama' => 'Loket Penyerahan', 'deskripsi' => 'Pengambilan dokumen hasil layanan', 'x' => '85%', 'y' => '65%'],
        ],
        'faqs' => [
            [
                'q' => 'Bagaimana jika BPKB masih dalam agunan / leasing?',
                'a' => 'Bawa surat keterangan dari pihak leasing beserta fotokopi legalisir BPKB.'
            ],
            [
                'q' => 'Apakah pengurusan layanan ini bisa diwakilkan?',
                'a' => 'Bisa diwakilkan dengan menyertakan Surat Kuasa bermaterai Rp 10.000 asli dan fotokopi KTP penerima kuasa.'
            ],
            [
                'q' => 'Berapa jam pelayanan SAMSAT Manyar?',
                'a' => 'Senin–Kamis 08.00–13.00 WIB, Jumat 08.00–11.30 WIB, Sabtu 08.00–12.00 WIB.'
            ]
        ]
    ];

    $kategoriPill = $meta['kategori_label'];
    $iconType = $meta['icon'];
    $subtitleDesc = $meta['subtitle'];
    $loketList = $meta['loket'];
    $faqList = $meta['faqs'];
    $berkasCount = $layanan->berkas->count();
    $langkahCount = $layanan->langkah->count();
@endphp

<div class="bg-[#EEF5FB] min-h-screen py-6 sm:py-10"
     x-data="{
        checkedDocs: [],
        totalDocs: {{ $berkasCount }},
        activeStep: 1,
        activePin: null,
        faqSearch: '',
        faqs: {{ json_encode($faqList) }},
        get readyCount() { return this.checkedDocs.length; },
        get progressPercent() { return this.totalDocs > 0 ? Math.round((this.readyCount / this.totalDocs) * 100) : 0; },
        toggleDoc(idx) {
            if (this.checkedDocs.includes(idx)) {
                this.checkedDocs = this.checkedDocs.filter(i => i !== idx);
            } else {
                this.checkedDocs.push(idx);
            }
        },
        filteredFaqs() {
            if (!this.faqSearch.trim()) return this.faqs;
            const q = this.faqSearch.toLowerCase();
            return this.faqs.filter(item => item.q.toLowerCase().includes(q) || item.a.toLowerCase().includes(q));
        }
     }">

    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">

        {{-- Top Navigation: Back Button + Breadcrumbs --}}
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('beranda') }}"
               class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-[#0B4DA2] hover:text-blue-900 bg-white border border-[#D9E7F4] px-4 py-2 rounded-xl shadow-sm hover:shadow transition group">
                <svg class="w-4 h-4 text-[#0B4DA2] transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>

            <nav class="text-xs text-gray-500 hidden sm:flex items-center gap-2">
                <a href="{{ route('beranda') }}" class="hover:text-[#0B4DA2] transition">Beranda</a>
                <span>/</span>
                <span class="text-gray-400">Jenis Layanan</span>
                <span>/</span>
                <span class="font-bold text-[#0F2851]">{{ $layanan->nama }}</span>
            </nav>
        </div>

        {{-- 1. Service Header Card (Matching Mockup) --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 mb-6 flex flex-col sm:flex-row items-start gap-5">
            {{-- Service Icon Circle --}}
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-[#EAF2FB] text-[#1E70D0] flex items-center justify-center shrink-0 shadow-inner">
                @if($iconType === 'ban')
                    {{-- Lapor Jual (Prohibited icon) --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                @elseif($iconType === 'logout')
                    {{-- Mutasi Keluar --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                @elseif($iconType === 'login')
                    {{-- Mutasi Masuk --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                @elseif($iconType === 'plus')
                    {{-- Kendaraan Baru --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @elseif($iconType === 'calendar')
                    {{-- Penul 5 Tahun --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                @elseif($iconType === 'swap')
                    {{-- BBN Intern --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                @else
                    {{-- STNK Duplikat / Default Document --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                @endif
            </div>

            <div class="flex-1">
                {{-- Category Pill --}}
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#EAF2FB] text-[#1E70D0] text-[11px] font-bold tracking-wider uppercase mb-2">
                    {{ $kategoriPill }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F2851] tracking-tight">
                    {{ $layanan->nama }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">
                    {{ $subtitleDesc }}
                </p>
            </div>
        </div>

        {{-- 2. Two-Column Main Content: Dokumen & Alur --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">

            {{-- LEFT COLUMN: Dokumen yang Harus Dibawa (Checklist) --}}
            <div class="lg:col-span-6 bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 flex flex-col justify-between">
                <div>
                    {{-- Column Header --}}
                    <div class="flex items-start gap-3 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-[#EAF2FB] text-[#1E70D0] flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-[#0F2851] leading-tight">
                                Dokumen yang Harus Dibawa
                            </h2>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Centang dokumen yang sudah Anda siapkan <strong class="text-gray-700 font-semibold">sebelum berangkat</strong>
                            </p>
                        </div>
                    </div>

                    {{-- Checklist Items --}}
                    <div class="space-y-3 mt-5">
                        @forelse($layanan->berkas as $index => $b)
                            @php
                                $isAsli = isset($b->wajib_asli) ? (bool)$b->wajib_asli : (stripos($b->teks, 'asli') !== false);
                                $fotokopiText = !empty($b->fotokopi) ? $b->fotokopi : (stripos($b->teks, 'fotokopi') !== false ? 'Fotokopi 1×' : null);
                            @endphp
                            <div x-on:click="toggleDoc({{ $index }})"
                                 class="p-3.5 rounded-xl border transition-all cursor-pointer select-none flex items-start justify-between gap-3"
                                 :class="checkedDocs.includes({{ $index }}) ? 'bg-[#F2F8FD] border-[#1E70D0]/40' : 'bg-[#FAFCFE] border-gray-100 hover:border-gray-200'">
                                <div class="flex items-start gap-3">
                                    {{-- Custom Checkbox --}}
                                    <div class="w-5 h-5 rounded-full border-2 transition-colors flex items-center justify-center shrink-0 mt-0.5"
                                         :class="checkedDocs.includes({{ $index }}) ? 'bg-[#1E70D0] border-[#1E70D0] text-white' : 'border-gray-300 bg-white'">
                                        <svg x-show="checkedDocs.includes({{ $index }})" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs sm:text-sm font-medium transition-colors leading-snug block"
                                              :class="checkedDocs.includes({{ $index }}) ? 'text-[#0F2851] font-semibold' : 'text-gray-700'">
                                            {{ $b->teks }}
                                        </span>
                                        @if(!empty($b->keterangan))
                                            <span class="text-[11px] text-gray-500 mt-0.5 block">
                                                {{ $b->keterangan }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Badges on Right --}}
                                <div class="flex flex-col sm:flex-row items-end sm:items-center gap-1 shrink-0">
                                    @if($isAsli)
                                        <span class="inline-block bg-[#E8F8EE] text-[#16A34A] border border-[#B9E9CA] text-[9px] font-extrabold px-1.5 py-0.5 rounded uppercase">
                                            ASLI
                                        </span>
                                    @endif
                                    @if(!empty($fotokopiText))
                                        <span class="inline-block bg-[#EBF3FC] text-[#1E70D0] border border-[#BFDBFE] text-[9px] font-extrabold px-1.5 py-0.5 rounded">
                                            {{ $fotokopiText }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-4">Belum ada daftar berkas khusus yang tercatat.</p>
                        @endforelse
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-1.5">
                            <span class="font-medium">
                                <span x-text="readyCount" class="font-bold text-[#1E70D0]"></span> dari <span x-text="totalDocs" class="font-bold"></span> dokumen siap
                            </span>
                            <span x-text="`${progressPercent}%`" class="font-mono font-bold text-[#1E70D0]"></span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-[#1E70D0] h-full rounded-full transition-all duration-300"
                                 :style="`width: ${progressPercent}%`"></div>
                        </div>
                    </div>
                </div>

                {{-- Catatan Penting Alert Box --}}
                <div class="mt-6 p-4 rounded-xl bg-[#EBF3FC] border border-[#BFDBFE] text-xs text-[#0F2851] leading-relaxed">
                    <div class="font-bold mb-1 flex items-center gap-1.5 text-[#1E70D0]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Catatan Penting:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-gray-600 pl-1">
                        <li>Fotokopi berukuran A4, tidak dipotong.</li>
                        <li>Bawa dokumen asli untuk ditunjukkan kepada petugas verifikator loket.</li>
                        <li>Pastikan nama dan NIK pada STNK, KTP, dan BPKB sesuai.</li>
                    </ul>
                </div>
            </div>

            {{-- RIGHT COLUMN: Alur Layanan di Loket --}}
            <div class="lg:col-span-6 bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 flex flex-col justify-between">
                <div>
                    {{-- Column Header --}}
                    <div class="flex items-start gap-3 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-[#EAF2FB] text-[#1E70D0] flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-[#0F2851] leading-tight">
                                Alur Layanan di Loket
                            </h2>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Klik setiap langkah untuk melihat lokasi dan petunjuk loket
                            </p>
                        </div>
                    </div>

                    {{-- Steps Accordion / List --}}
                    <div class="space-y-3 mt-5">
                        @forelse($layanan->langkah as $idx => $l)
                            @php
                                $stepNum = $l->urutan ?: ($idx + 1);
                                $loketItem = $loketList[$idx % count($loketList)] ?? null;
                                $loketCode = !empty($l->kode_loket) ? $l->kode_loket : ($loketItem['kode'] ?? 'LKT');
                                $loketName = $l->teks;
                                $stepKeterangan = !empty($l->keterangan) ? $l->keterangan : ($loketItem['deskripsi'] ?? $l->teks);
                            @endphp
                            <div x-data="{ open: {{ $stepNum === 1 ? 'true' : 'false' }} }"
                                 class="rounded-xl border border-gray-100 bg-[#FAFCFE] transition overflow-hidden">
                                <button type="button"
                                        x-on:click="open = !open; activePin = '{{ $loketCode }}'"
                                        class="w-full p-3.5 text-left flex items-center justify-between gap-3 hover:bg-[#F2F8FD] transition">
                                    <div class="flex items-center gap-3">
                                        {{-- Step Number Circle --}}
                                        <div class="w-7 h-7 rounded-full bg-[#0B4DA2] text-white font-extrabold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            {{ $stepNum }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs sm:text-sm font-bold text-[#0F2851]">
                                                    {{ $loketName }}
                                                </span>
                                                <span class="bg-[#EAF2FB] text-[#1E70D0] text-[10px] font-extrabold px-1.5 py-0.2 rounded font-mono">
                                                    {{ $loketCode }}
                                                </span>
                                            </div>
                                            <p class="text-[11px] text-gray-500 line-clamp-1 mt-0.5">
                                                {{ $stepKeterangan }}
                                            </p>
                                        </div>
                                    </div>

                                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0"
                                         :class="open ? 'rotate-180' : ''"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <div x-show="open" x-transition class="px-4 pb-3 pt-1 text-xs text-gray-600 border-t border-gray-100 bg-white">
                                    <p class="leading-relaxed">
                                        <strong>Petunjuk:</strong> {{ $stepKeterangan }}
                                    </p>
                                    @if($loketItem)
                                        <p class="text-[11px] text-[#1E70D0] mt-1.5 font-medium flex items-center gap-1">
                                            <span>📍 Lokasi:</span> {{ $loketItem['deskripsi'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-4">Belum ada alur langkah khusus yang tercatat.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Finish Status Banner (Green/Blue Bar matching mockup) --}}
                <div class="mt-6">
                    <div class="p-4 rounded-xl bg-[#09418A] text-white flex items-center justify-between shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-xs sm:text-sm block">Selesai di Loket Penyerahan</span>
                                <span class="text-[10px] text-blue-200 block">Klik untuk melihat ringkasan &amp; langkah terakhir sebelum pulang</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-blue-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-gray-400 mt-2 px-1">
                        <span>TANGGAL CETAK: {{ date('d/M/Y') }}</span>
                        <span>Terakreditasi Dinas Pendapatan Pajak Kendaraan Bermotor Anda</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Denah Gedung & Lokasi Loket --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 mb-8">
            <div class="mb-5">
                <h2 class="text-lg sm:text-xl font-bold text-[#0F2851] tracking-tight">
                    Denah Gedung &amp; Lokasi Loket
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                    KB SAMSAT Surabaya Timur · Jl. Manyar Kertoarjo No. 1
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                {{-- Left: Floor Plan Map Schematic SVG --}}
                <div class="lg:col-span-8 bg-[#F4F9FD] border border-[#CFE2F3] rounded-2xl p-4 sm:p-6 relative overflow-hidden shadow-inner">
                    {{-- Schematic Layout Map --}}
                    <div class="relative w-full aspect-[16/9] min-h-[260px] bg-white rounded-xl border-2 border-dashed border-[#B8D5ED] p-3 text-xs select-none">
                        {{-- Doors --}}
                        <div class="absolute top-2 left-3 bg-[#0B4DA2] text-white font-bold text-[10px] px-2.5 py-1 rounded-md shadow-sm">
                            Pintu Masuk
                        </div>
                        <div class="absolute top-2 right-3 bg-[#16A34A] text-white font-bold text-[10px] px-2.5 py-1 rounded-md shadow-sm">
                            Pintu Keluar
                        </div>

                        {{-- Lobby Hall --}}
                        <div class="absolute top-10 left-3 right-3 h-14 bg-[#EDF5FC] rounded-lg border border-[#D0E4F5] flex items-center justify-center text-gray-400 font-semibold text-[11px]">
                            Lobby / Tangga
                        </div>

                        {{-- Main Hall Sections --}}
                        <div class="absolute top-28 left-3 w-[55%] bottom-3 bg-[#F8FAFC] rounded-lg border border-gray-200 p-2 flex flex-col justify-end text-gray-400 text-[11px] font-medium">
                            <span class="text-center pb-2">Ruang Layanan Utama</span>
                        </div>

                        {{-- Cashier & Physical Check --}}
                        <div class="absolute top-28 right-3 w-[38%] h-20 bg-[#EDF5FC] rounded-lg border border-[#D0E4F5] flex items-center justify-center text-gray-400 font-medium text-[11px]">
                            Area Kasir
                        </div>
                        <div class="absolute bottom-3 right-3 w-[38%] h-16 bg-[#E8F8EE] rounded-lg border border-[#B9E9CA] flex items-center justify-center text-gray-500 font-medium text-[11px]">
                            Area Parkir &amp; Cek Fisik
                        </div>

                        {{-- Dynamic Loket Pins on Map --}}
                        @foreach($loketList as $lkt)
                            <div class="absolute transform -translate-x-1/2 -translate-y-1/2 transition-transform hover:scale-125 cursor-pointer z-10"
                                 style="left: {{ $lkt['x'] }}; top: {{ $lkt['y'] }};"
                                 x-on:click="activePin = '{{ $lkt['kode'] }}'">
                                <div class="px-2 py-1 rounded-full font-bold text-[10px] shadow-md border flex items-center gap-1 transition-colors"
                                     :class="activePin === '{{ $lkt['kode'] }}' ? 'bg-amber-400 text-gray-900 border-amber-500 ring-2 ring-amber-300' : 'bg-[#1E70D0] text-white border-white'">
                                    <span>{{ $lkt['kode'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <p class="text-[11px] text-gray-400 text-center mt-2.5">
                        Arahkan kursor ke pin atau klik loket di samping untuk melihat lokasi loket di gedung
                    </p>
                </div>

                {{-- Right: Lokasi Loket Layanan Ini --}}
                <div class="lg:col-span-4 space-y-3">
                    <h3 class="text-xs sm:text-sm font-bold text-[#0F2851] uppercase tracking-wider mb-2">
                        Lokasi Loket Layanan Ini
                    </h3>

                    @foreach($loketList as $lkt)
                        <div x-on:click="activePin = '{{ $lkt['kode'] }}'"
                             class="p-3.5 rounded-xl border transition-all cursor-pointer flex items-center justify-between gap-3 shadow-sm"
                             :class="activePin === '{{ $lkt['kode'] }}' ? 'bg-[#EDF5FD] border-[#1E70D0] ring-1 ring-[#1E70D0]' : 'bg-white border-gray-100 hover:border-gray-200'">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#0B4DA2] text-white font-mono font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ $lkt['kode'] }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#0F2851] leading-tight">
                                        {{ $lkt['nama'] }}
                                    </h4>
                                    <span class="text-[10px] text-[#1E70D0] font-medium mt-0.5 block">
                                        Lihat di peta &rarr;
                                    </span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 4. Jam Operasional & Indikator Keramaian (Big Blue Card matching Mockup) --}}
        <div class="bg-[#0B4DA2] text-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 mb-8 shadow-lg">
            <div>
                <h2 class="text-lg sm:text-xl font-extrabold tracking-tight">
                    Jam Operasional &amp; Indikator Keramaian
                </h2>
                <p class="text-xs sm:text-sm text-blue-100/90 mt-0.5">
                    Datanglah lebih awal untuk menghindari antrean panjang
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                {{-- Inner Card 1: JADWAL OPERASIONAL --}}
                <div class="bg-white rounded-2xl p-5 text-gray-800 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold tracking-wider text-gray-400 uppercase block mb-3">
                            JADWAL OPERASIONAL
                        </span>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between pb-1.5 border-b border-gray-100">
                                <span class="font-medium text-gray-600">Senin – Kamis</span>
                                <span class="font-bold text-[#0F2851]">08.00 – 13.00 WIB</span>
                            </div>
                            <div class="flex items-center justify-between pb-1.5 border-b border-gray-100">
                                <span class="font-medium text-gray-600">Jumat</span>
                                <span class="font-bold text-[#0F2851]">08.00 – 11.30 WIB</span>
                            </div>
                            <div class="flex items-center justify-between pb-1.5 border-b border-gray-100 bg-blue-50/60 -mx-2 px-2 py-1 rounded">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold text-[#0B4DA2]">Sabtu</span>
                                    <span class="bg-[#0B4DA2] text-white text-[9px] font-bold px-1.5 py-0.2 rounded">Hari ini</span>
                                </div>
                                <span class="font-bold text-[#0B4DA2]">08.00 – 12.00 WIB</span>
                            </div>
                            <div class="flex items-center justify-between pt-1">
                                <span class="font-medium text-gray-400">Minggu</span>
                                <span class="font-bold text-red-500">Tutup</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Inner Card 2: STATUS KERAMAIAN SEKARANG --}}
                <div class="bg-white rounded-2xl p-5 text-gray-800 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold tracking-wider text-gray-400 uppercase block mb-3">
                            STATUS KERAMAIAN SEKARANG
                        </span>
                        <div class="mt-2">
                            <span class="text-lg font-extrabold text-[#0F2851] block">
                                {{ date('l, H.i') }} WIB
                            </span>

                            <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-orange-50 border border-orange-200 text-orange-700 text-xs font-bold">
                                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                                <span>Waktu Puncak Antrean (Peak Hours)</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-[10px] text-gray-400 mt-4 leading-relaxed">
                        Estimasi berdasarkan pola kunjungan historis. Kondisi aktual loket dapat berubah sewaktu-waktu.
                    </p>
                </div>

                {{-- Inner Card 3: POLA KERAMAIAN HARIAN --}}
                <div class="bg-white rounded-2xl p-5 text-gray-800 shadow-sm">
                    <span class="text-[10px] font-extrabold tracking-wider text-gray-400 uppercase block mb-3">
                        POLA KERAMAIAN HARIAN
                    </span>

                    <div class="space-y-2 text-xs">
                        {{-- 08.00 - 09.30 --}}
                        <div>
                            <div class="flex justify-between text-[11px] mb-0.5">
                                <span class="text-gray-500">08.00 – 09.30</span>
                                <span class="text-emerald-600 font-bold">Sepi</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full w-[30%]"></div>
                            </div>
                        </div>

                        {{-- 09.30 - 10.30 --}}
                        <div>
                            <div class="flex justify-between text-[11px] mb-0.5">
                                <span class="text-gray-500">09.30 – 10.30</span>
                                <span class="text-amber-500 font-bold">Mulai Ramai</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-amber-400 h-full w-[65%]"></div>
                            </div>
                        </div>

                        {{-- 10.30 - 12.30 --}}
                        <div>
                            <div class="flex justify-between text-[11px] mb-0.5">
                                <span class="text-gray-500">10.30 – 12.30</span>
                                <span class="text-red-600 font-bold">Puncak</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-red-500 h-full w-[95%]"></div>
                            </div>
                        </div>

                        {{-- 12.30 - 13.30 --}}
                        <div>
                            <div class="flex justify-between text-[11px] mb-0.5">
                                <span class="text-gray-500">12.30 – 13.30</span>
                                <span class="text-amber-500 font-bold">Mulai Sepi</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-amber-400 h-full w-[55%]"></div>
                            </div>
                        </div>

                        {{-- 13.30 - 14.30 --}}
                        <div>
                            <div class="flex justify-between text-[11px] mb-0.5">
                                <span class="text-gray-500">13.30 – 14.30</span>
                                <span class="text-blue-600 font-bold">Hampir Sedang</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full w-[38%]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. Pertanyaan Sering Ditanyakan (FAQ) with Search --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#D9E7F4] shadow-sm p-6 sm:p-8 mb-8">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-[#0F2851] tracking-tight">
                    Pertanyaan Sering Ditanyakan (FAQ)
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                    Temukan jawaban cepat sebelum datang ke SAMSAT
                </p>
            </div>

            {{-- FAQ Search Input --}}
            <div class="relative mt-5 mb-5">
                <input type="text"
                       x-model="faqSearch"
                       placeholder="Cari pertanyaan... (contoh: BPKB Leasing, Surat Kuasa)"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 text-xs sm:text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0B4DA2] focus:border-transparent transition bg-[#FBFDFE]">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            {{-- FAQ Accordion Items --}}
            <div class="space-y-3">
                <template x-for="(faq, fIndex) in filteredFaqs()" :key="fIndex">
                    <div x-data="{ openFaq: false }"
                         class="rounded-xl border border-gray-100 bg-[#FAFCFE] overflow-hidden transition">
                        <button type="button"
                                x-on:click="openFaq = !openFaq"
                                class="w-full p-4 text-left flex items-center justify-between gap-4 hover:bg-[#F2F8FD] transition">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-[#EAF2FB] text-[#1E70D0] font-bold text-xs flex items-center justify-center shrink-0">
                                    <span x-text="fIndex + 1"></span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-[#0F2851]" x-text="faq.q"></span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0"
                                 :class="openFaq ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openFaq" x-transition class="px-5 pb-4 pt-1 text-xs sm:text-sm text-gray-600 border-t border-gray-100 bg-white leading-relaxed" x-text="faq.a"></div>
                    </div>
                </template>

                <p x-show="filteredFaqs().length === 0" class="text-xs text-gray-400 text-center py-6">
                    Tidak ditemukan pertanyaan yang cocok dengan pencarian Anda.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
