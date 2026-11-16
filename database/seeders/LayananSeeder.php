<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Layanan
        $kategori = [
            ['nama' => 'Pendaftaran', 'warna' => '#2563EB', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Mutasi', 'warna' => '#7C3AED', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Perpanjangan', 'warna' => '#059669', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Duplikat', 'warna' => '#D97706', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('kategori_layanan')->insert($kategori);

        $katIds = DB::table('kategori_layanan')->pluck('id', 'nama');

        $layanan = [
            [
                'slug' => 'lapor-jual',
                'nama' => 'Lapor Jual',
                'deskripsi' => 'Pelaporan penjualan kendaraan bermotor agar pajak tidak dibebankan pada pemilik lama.',
                'kategori_id' => $katIds['Pendaftaran'],
                'warna' => '#1E88E5',
                'terpublikasi' => true,
                'berkas' => [
                    'KTP asli pemilik lama',
                    'Fotokopi KTP pemilik lama',
                    'STNK asli',
                    'Fotokopi STNK',
                    'Kwitansi jual beli bermaterai',
                ],
                'langkah' => [
                    'Siapkan semua berkas persyaratan',
                    'Datang ke loket Samsat Manyar',
                    'Ambil nomor antrian dan isi formulir lapor jual',
                    'Serahkan berkas ke petugas di loket pendaftaran',
                    'Tunggu proses verifikasi data',
                    'Terima bukti lapor jual',
                ],
            ],
            [
                'slug' => 'mutasi-keluar',
                'nama' => 'Mutasi Keluar',
                'deskripsi' => 'Proses pemindahan data kendaraan dari Samsat Manyar ke Samsat daerah tujuan.',
                'kategori_id' => $katIds['Mutasi'],
                'warna' => '#8E24AA',
                'terpublikasi' => true,
                'berkas' => [
                    'KTP asli pemilik',
                    'STNK asli',
                    'BPKB asli',
                    'Kwitansi pembelian bermaterai (jika pindah tangan)',
                    'Bukti pelunasan pajak terakhir',
                    'Hasil cek fisik kendaraan',
                ],
                'langkah' => [
                    'Lakukan cek fisik kendaraan di area cek fisik Samsat',
                    'Siapkan semua berkas persyaratan',
                    'Datang ke loket mutasi dan isi formulir',
                    'Serahkan berkas beserta hasil cek fisik',
                    'Bayar biaya administrasi mutasi keluar',
                    'Tunggu proses pencabutan berkas (± 1-3 hari kerja)',
                    'Ambil berkas cabutan untuk dibawa ke Samsat tujuan',
                ],
            ],
            [
                'slug' => 'mutasi-masuk',
                'nama' => 'Mutasi Masuk',
                'deskripsi' => 'Proses pendaftaran kendaraan dari daerah lain masuk ke wilayah Samsat Manyar.',
                'kategori_id' => $katIds['Mutasi'],
                'warna' => '#6A1B9A',
                'terpublikasi' => true,
                'berkas' => [
                    'KTP asli pemilik baru',
                    'Berkas cabutan dari Samsat asal',
                    'BPKB asli',
                    'Hasil cek fisik kendaraan',
                    'Kwitansi pembelian bermaterai',
                    'STNK lama',
                ],
                'langkah' => [
                    'Lakukan cek fisik kendaraan di Samsat Manyar',
                    'Siapkan semua berkas persyaratan termasuk cabutan',
                    'Datang ke loket pendaftaran mutasi masuk',
                    'Serahkan berkas dan formulir yang sudah diisi',
                    'Bayar PKB dan biaya administrasi',
                    'Tunggu penerbitan STNK dan plat nomor baru',
                    'Ambil STNK dan plat nomor baru',
                ],
            ],
            [
                'slug' => 'kendaraan-baru',
                'nama' => 'Kendaraan Baru',
                'deskripsi' => 'Pendaftaran kendaraan bermotor baru untuk mendapatkan STNK dan plat nomor.',
                'kategori_id' => $katIds['Pendaftaran'],
                'warna' => '#1565C0',
                'terpublikasi' => true,
                'berkas' => [
                    'KTP asli pemilik',
                    'Fotokopi KTP pemilik',
                    'Faktur kendaraan dari dealer',
                    'Sertifikat uji tipe / NIK kendaraan',
                    'Bukti hasil cek fisik kendaraan',
                    'Surat keterangan dari dealer',
                ],
                'langkah' => [
                    'Lakukan cek fisik kendaraan baru di Samsat',
                    'Siapkan semua berkas dari dealer',
                    'Datang ke loket pendaftaran kendaraan baru',
                    'Isi formulir pendaftaran',
                    'Serahkan berkas ke petugas',
                    'Bayar PKB, BBN-KB, dan biaya administrasi',
                    'Tunggu proses penerbitan STNK dan TNKB',
                    'Ambil STNK sementara, plat nomor menyusul',
                ],
            ],
            [
                'slug' => 'stnk-duplikat',
                'nama' => 'STNK Duplikat',
                'deskripsi' => 'Penerbitan STNK pengganti karena hilang atau rusak.',
                'kategori_id' => $katIds['Duplikat'],
                'warna' => '#E65100',
                'terpublikasi' => true,
                'berkas' => [
                    'KTP asli pemilik',
                    'BPKB asli',
                    'Surat keterangan hilang dari kepolisian (jika hilang)',
                    'STNK rusak (jika rusak)',
                    'Bukti pelunasan pajak terakhir',
                    'Hasil cek fisik kendaraan',
                ],
                'langkah' => [
                    'Buat surat keterangan hilang di kantor polisi (jika hilang)',
                    'Lakukan cek fisik kendaraan',
                    'Siapkan semua berkas persyaratan',
                    'Datang ke loket STNK duplikat',
                    'Isi formulir permohonan duplikat STNK',
                    'Bayar biaya administrasi',
                    'Tunggu penerbitan STNK duplikat',
                ],
            ],
            [
                'slug' => 'perpanjangan-5-tahunan',
                'nama' => 'Perpanjangan 5 Tahunan',
                'deskripsi' => 'Perpanjangan STNK setiap 5 tahun disertai penggantian plat nomor (TNKB).',
                'kategori_id' => $katIds['Perpanjangan'],
                'warna' => '#2E7D32',
                'terpublikasi' => true,
                'berkas' => [
                    'KTP asli pemilik sesuai STNK',
                    'STNK asli',
                    'BPKB asli',
                    'Hasil cek fisik kendaraan',
                    'Bukti pelunasan pajak tahun berjalan',
                ],
                'langkah' => [
                    'Lakukan cek fisik kendaraan di area Samsat',
                    'Siapkan semua berkas persyaratan',
                    'Datang ke loket perpanjangan 5 tahunan',
                    'Serahkan berkas dan hasil cek fisik',
                    'Bayar PKB dan biaya TNKB baru',
                    'Tunggu proses penerbitan STNK baru',
                    'Ambil STNK baru dan plat nomor baru',
                ],
            ],
            [
                'slug' => 'bbn-intern',
                'nama' => 'BBN Intern (Balik Nama)',
                'deskripsi' => 'Proses balik nama STNK dan BPKB dalam satu wilayah Samsat Manyar.',
                'kategori_id' => $katIds['Pendaftaran'],
                'warna' => '#0277BD',
                'terpublikasi' => true,
                'berkas' => [
                    'KTP asli pemilik baru',
                    'Fotokopi KTP pemilik baru',
                    'STNK asli',
                    'BPKB asli',
                    'Kwitansi jual beli bermaterai',
                    'Hasil cek fisik kendaraan',
                ],
                'langkah' => [
                    'Lakukan cek fisik kendaraan',
                    'Siapkan semua berkas persyaratan',
                    'Datang ke loket balik nama (BBN)',
                    'Isi formulir permohonan BBN',
                    'Serahkan berkas ke petugas',
                    'Bayar BBN-KB, PKB, dan biaya administrasi',
                    'Tunggu proses penerbitan STNK dan BPKB baru',
                    'Ambil STNK baru, BPKB menyusul',
                ],
            ],
        ];

        foreach ($layanan as $item) {
            $berkas = $item['berkas'];
            $langkahList = $item['langkah'];
            unset($item['berkas'], $item['langkah']);
            $item['created_at'] = now();
            $item['updated_at'] = now();

            $layananId = DB::table('layanan')->insertGetId($item);

            foreach ($berkas as $i => $teks) {
                DB::table('layanan_berkas')->insert([
                    'layanan_id' => $layananId,
                    'urutan' => $i + 1,
                    'teks' => $teks,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($langkahList as $i => $teks) {
                DB::table('layanan_langkah')->insert([
                    'layanan_id' => $layananId,
                    'urutan' => $i + 1,
                    'teks' => $teks,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
