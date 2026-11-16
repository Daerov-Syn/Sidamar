<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLayananRequest;
use App\Http\Requests\UpdateLayananRequest;
use App\Models\KategoriLayanan;
use App\Models\Layanan;
use Illuminate\Support\Str;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::with('kategori')
            ->withCount(['berkas', 'langkah'])
            ->orderBy('id')
            ->get();

        return view('admin.layanan.index', compact('layanan'));
    }

    public function create()
    {
        $kategori = KategoriLayanan::orderBy('nama')->get();
        return view('admin.layanan.create', compact('kategori'));
    }

    public function store(StoreLayananRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['nama']);
        $data['terpublikasi'] = $request->has('terpublikasi') ? $request->boolean('terpublikasi') : true;

        $layanan = Layanan::create($data);

        // Simpan berkas
        $urutanBerkas = 1;
        foreach ($request->input('berkas', []) as $item) {
            if (is_array($item)) {
                $nama = trim($item['nama'] ?? $item['teks'] ?? '');
                if ($nama !== '') {
                    $layanan->berkas()->create([
                        'urutan'     => $urutanBerkas++,
                        'teks'       => $nama,
                        'fotokopi'   => !empty($item['fotokopi']) ? trim($item['fotokopi']) : null,
                        'wajib_asli' => !empty($item['wajib_asli']),
                        'keterangan' => !empty($item['keterangan']) ? trim($item['keterangan']) : null,
                    ]);
                }
            } elseif (is_string($item) && trim($item) !== '') {
                $layanan->berkas()->create([
                    'urutan'     => $urutanBerkas++,
                    'teks'       => trim($item),
                    'fotokopi'   => null,
                    'wajib_asli' => true,
                    'keterangan' => null,
                ]);
            }
        }

        // Simpan langkah
        $urutanLangkah = 1;
        foreach ($request->input('langkah', []) as $item) {
            if (is_array($item)) {
                $nama = trim($item['nama'] ?? $item['teks'] ?? '');
                if ($nama !== '') {
                    $layanan->langkah()->create([
                        'urutan'     => $urutanLangkah++,
                        'teks'       => $nama,
                        'kode_loket' => !empty($item['kode_loket']) ? trim($item['kode_loket']) : null,
                        'keterangan' => !empty($item['keterangan']) ? trim($item['keterangan']) : null,
                    ]);
                }
            } elseif (is_string($item) && trim($item) !== '') {
                $layanan->langkah()->create([
                    'urutan'     => $urutanLangkah++,
                    'teks'       => trim($item),
                    'kode_loket' => null,
                    'keterangan' => null,
                ]);
            }
        }

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        $layanan->load(['berkas', 'langkah', 'kategori']);
        $kategori = KategoriLayanan::orderBy('nama')->get();
        return view('admin.layanan.edit', compact('layanan', 'kategori'));
    }

    public function update(UpdateLayananRequest $request, Layanan $layanan)
    {
        $data = $request->validated();
        if ($request->has('terpublikasi')) {
            $data['terpublikasi'] = $request->boolean('terpublikasi');
        }

        $layanan->update($data);

        // Sync berkas
        $layanan->berkas()->delete();
        $urutanBerkas = 1;
        foreach ($request->input('berkas', []) as $item) {
            if (is_array($item)) {
                $nama = trim($item['nama'] ?? $item['teks'] ?? '');
                if ($nama !== '') {
                    $layanan->berkas()->create([
                        'urutan'     => $urutanBerkas++,
                        'teks'       => $nama,
                        'fotokopi'   => !empty($item['fotokopi']) ? trim($item['fotokopi']) : null,
                        'wajib_asli' => !empty($item['wajib_asli']),
                        'keterangan' => !empty($item['keterangan']) ? trim($item['keterangan']) : null,
                    ]);
                }
            } elseif (is_string($item) && trim($item) !== '') {
                $layanan->berkas()->create([
                    'urutan'     => $urutanBerkas++,
                    'teks'       => trim($item),
                    'fotokopi'   => null,
                    'wajib_asli' => true,
                    'keterangan' => null,
                ]);
            }
        }

        // Sync langkah
        $layanan->langkah()->delete();
        $urutanLangkah = 1;
        foreach ($request->input('langkah', []) as $item) {
            if (is_array($item)) {
                $nama = trim($item['nama'] ?? $item['teks'] ?? '');
                if ($nama !== '') {
                    $layanan->langkah()->create([
                        'urutan'     => $urutanLangkah++,
                        'teks'       => $nama,
                        'kode_loket' => !empty($item['kode_loket']) ? trim($item['kode_loket']) : null,
                        'keterangan' => !empty($item['keterangan']) ? trim($item['keterangan']) : null,
                    ]);
                }
            } elseif (is_string($item) && trim($item) !== '') {
                $layanan->langkah()->create([
                    'urutan'     => $urutanLangkah++,
                    'teks'       => trim($item),
                    'kode_loket' => null,
                    'keterangan' => null,
                ]);
            }
        }

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
