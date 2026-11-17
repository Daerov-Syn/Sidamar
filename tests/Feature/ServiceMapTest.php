<?php

namespace Tests\Feature;

use App\Models\Layanan;
use Database\Seeders\LayananSeeder;
use Tests\TestCase;

class ServiceMapTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->migrateServiceTables();

        $this->seed(LayananSeeder::class);
    }

    public function test_all_service_pages_use_their_own_steps_and_documents_in_the_map(): void
    {
        $services = Layanan::with(['langkah', 'berkas'])->get();

        $this->assertCount(7, $services);

        foreach ($services as $service) {
            $response = $this->get(route('layanan.show', $service->slug));

            $response->assertOk();
            $response->assertSeeText('Lihat Alur di Denah');
            $response->assertSeeText('Ilustrasi alur layanan');
            $response->assertSee('x-data="serviceMap"', false);
            $response->assertSee('x-data="serviceDetail"', false);
            $this->assertStringNotContainsString("'unsafe-eval'", $response->headers->get('Content-Security-Policy'));
            $response->assertSeeText($service->nama);

            foreach ($service->langkah as $step) {
                $response->assertSeeText($step->teks);
            }

            foreach ($service->berkas as $document) {
                $response->assertSeeText($document->teks);
            }
        }
    }

    public function test_updated_steps_and_documents_are_shared_with_the_map_without_guessed_locations(): void
    {
        $service = Layanan::where('slug', 'stnk-duplikat')->firstOrFail();
        $service->langkah()->delete();
        $service->langkah()->createMany([
            ['urutan' => 10, 'teks' => 'Tahap data lama', 'kode_loket' => null, 'keterangan' => null],
            ['urutan' => 20, 'teks' => 'Kasir pertama', 'kode_loket' => 'KAS', 'keterangan' => 'Petunjuk terbaru'],
            ['urutan' => 30, 'teks' => 'Kembali ke kasir', 'kode_loket' => 'KAS'],
        ]);
        $service->berkas()->create(['urutan' => 99, 'teks' => 'Berkas terbaru dari pengelola']);

        $response = $this->get(route('layanan.show', $service->slug));

        $response->assertOk();
        $response->assertSeeTextInOrder(['Tahap data lama', 'Kasir pertama', 'Kembali ke kasir']);
        $response->assertSeeText('Petunjuk terbaru');
        $response->assertSeeText('Berkas terbaru dari pengelola');
        $response->assertDontSee('Gesek nomor rangka &amp; mesin di area cek fisik', false);
        $response->assertSee('{ step: 0 }', false);

        $this->get(route('layanan.show', 'mutasi-keluar'))
            ->assertOk()
            ->assertSeeText('Mutasi Keluar')
            ->assertDontSeeText('Berkas terbaru dari pengelola')
            ->assertDontSeeText('Petunjuk terbaru');
    }

    public function test_empty_service_keeps_detail_accessible_without_opening_an_empty_route(): void
    {
        $service = Layanan::firstOrFail();
        $service->langkah()->delete();

        $this->get(route('layanan.show', $service->slug))
            ->assertOk()
            ->assertSeeText('Belum ada alur langkah khusus yang tercatat.')
            ->assertDontSeeText('Lihat Alur di Denah');
    }

    public function test_homepage_links_to_details_and_feedback_portal(): void
    {
        $response = $this->get(route('beranda'));

        $response->assertOk();
        $response->assertSee(route('layanan.show', 'stnk-duplikat'));
        $response->assertSee(route('layanan.show', 'mutasi-keluar'));
        $response->assertSee(route('masukan.create'));
        $response->assertSeeText('Kritik & Saran');
    }
}
