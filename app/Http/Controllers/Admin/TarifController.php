<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTarifRequest;
use App\Http\Requests\UpdateTarifRequest;
use App\Models\AuditLog;
use App\Models\JenisKendaraan;
use App\Models\TarifPajak;
use Illuminate\Support\Facades\DB;

class TarifController extends Controller
{
    public function index()
    {
        $tarif = TarifPajak::with('jenisKendaraan')->orderBy('jenis_id')->orderBy('tahun_min')->get();
        $jenisKendaraan = JenisKendaraan::orderBy('nama')->get();
        $riwayat = AuditLog::where('tabel', 'tarif_pajak')->latest('waktu')->take(20)->get();

        return view('admin.tarif.index', compact('tarif', 'jenisKendaraan', 'riwayat'));
    }

    public function store(StoreTarifRequest $request)
    {
        TarifPajak::create($request->validated());
        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function update(UpdateTarifRequest $request, TarifPajak $tarif)
    {
        $tarif->update($request->validated());
        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(TarifPajak $tarif)
    {
        $tarif->delete();
        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
