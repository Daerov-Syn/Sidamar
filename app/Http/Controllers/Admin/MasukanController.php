<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMasukanStatusRequest;
use App\Models\Masukan;
use Illuminate\Http\Request;

class MasukanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query  = Masukan::latest();

        if ($status && in_array($status, ['Baru', 'Ditinjau', 'Selesai'])) {
            $query->where('status', $status);
        }

        $masukan = $query->paginate(20)->withQueryString();

        $counts = [
            'semua'    => Masukan::count(),
            'Baru'     => Masukan::where('status', 'Baru')->count(),
            'Ditinjau' => Masukan::where('status', 'Ditinjau')->count(),
            'Selesai'  => Masukan::where('status', 'Selesai')->count(),
        ];

        return view('admin.masukan.index', compact('masukan', 'counts', 'status'));
    }

    public function updateStatus(UpdateMasukanStatusRequest $request, Masukan $masukan)
    {
        $masukan->update(['status' => $request->validated('status')]);

        return back()->with('success', 'Status masukan berhasil diperbarui.');
    }
}
