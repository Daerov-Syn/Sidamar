<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\PromoPemutihan;

class BerandaController extends Controller
{
    public function index()
    {
        $layanan = Layanan::with('kategori')
            ->terpublikasi()
            ->withCount(['berkas', 'langkah'])
            ->orderBy('id', 'asc')
            ->get();

        $promoAktif = PromoPemutihan::aktif()->get();

        return view('public.beranda', compact('layanan', 'promoAktif'));
    }
}
