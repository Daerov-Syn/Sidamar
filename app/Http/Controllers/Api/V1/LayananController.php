<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        $data = Layanan::with('kategori')
            ->terpublikasi()
            ->withCount(['berkas', 'langkah'])
            ->get();

        return response()->json(['data' => $data]);
    }

    public function show(string $slug)
    {
        $layanan = Layanan::with(['kategori', 'berkas', 'langkah'])
            ->terpublikasi()
            ->where('slug', $slug)
            ->first();

        if (! $layanan) {
            return response()->json([
                'error' => ['code' => 'NOT_FOUND', 'message' => 'Layanan tidak ditemukan.'],
            ], 404);
        }

        return response()->json(['data' => $layanan]);
    }
}
