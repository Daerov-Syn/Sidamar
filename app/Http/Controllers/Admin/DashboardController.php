<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Masukan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil ringkasan dari View
        $ringkasan = DB::table('v_dashboard_ringkasan')->first();
        $statusMasukan = DB::table('v_status_masukan')->get()->keyBy('status');
        $masukanTerbaru = Masukan::latest()->take(5)->get();
        $layananAktif = Layanan::with('kategori')
            ->terpublikasi()
            ->withCount(['berkas', 'langkah'])
            ->get();

        return view('admin.dashboard', compact(
            'ringkasan', 'statusMasukan', 'masukanTerbaru', 'layananAktif'
        ));
    }
}
