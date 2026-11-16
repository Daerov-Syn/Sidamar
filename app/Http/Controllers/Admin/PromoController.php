<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromoRequest;
use App\Http\Requests\UpdatePromoRequest;
use App\Models\AuditLog;
use App\Models\PromoPemutihan;

class PromoController extends Controller
{
    public function index()
    {
        $promo = PromoPemutihan::orderByDesc('mulai')->get();
        $riwayat = AuditLog::where('tabel', 'promo_pemutihan')->latest('waktu')->take(20)->get();
        return view('admin.promo.index', compact('promo', 'riwayat'));
    }

    public function store(StorePromoRequest $request)
    {
        PromoPemutihan::create($request->validated());
        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function update(UpdatePromoRequest $request, PromoPemutihan $promo)
    {
        $promo->update($request->validated());
        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(PromoPemutihan $promo)
    {
        $promo->delete();
        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil dihapus.');
    }
}
