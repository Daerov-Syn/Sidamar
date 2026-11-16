<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDendaRequest;
use App\Http\Requests\UpdateDendaRequest;
use App\Models\AturanDenda;
use App\Models\AuditLog;

class DendaController extends Controller
{
    public function index()
    {
        $denda = AturanDenda::orderBy('periode_min_bulan')->get();
        $riwayat = AuditLog::where('tabel', 'aturan_denda')->latest('waktu')->take(20)->get();
        return view('admin.denda.index', compact('denda', 'riwayat'));
    }

    public function store(StoreDendaRequest $request)
    {
        AturanDenda::create($request->validated());
        return redirect()->route('admin.denda.index')->with('success', 'Aturan denda berhasil ditambahkan.');
    }

    public function update(UpdateDendaRequest $request, AturanDenda $denda)
    {
        $denda->update($request->validated());
        return redirect()->route('admin.denda.index')->with('success', 'Aturan denda berhasil diperbarui.');
    }

    public function destroy(AturanDenda $denda)
    {
        $denda->delete();
        return redirect()->route('admin.denda.index')->with('success', 'Aturan denda berhasil dihapus.');
    }
}
