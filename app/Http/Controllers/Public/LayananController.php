<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\KategoriLayanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $query = Layanan::with('kategori')
            ->terpublikasi()
            ->withCount(['berkas', 'langkah']);

        if ($request->filled('q')) {
            $keyword = $request->string('q')->trim()->limit(100)->toString();
            $query->where('nama', 'like', '%' . $keyword . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', (int) $request->input('kategori'));
        }

        $layanan = $query->get();
        $kategori = KategoriLayanan::orderBy('nama')->get();

        return view('public.layanan', compact('layanan', 'kategori'));
    }

    public function show(string $slug)
    {
        $layanan = Layanan::with(['kategori', 'berkas', 'langkah'])
            ->terpublikasi()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.layanan-detail', compact('layanan'));
    }
}
