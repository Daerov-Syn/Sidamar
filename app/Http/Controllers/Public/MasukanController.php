<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasukanRequest;
use App\Models\Masukan;

class MasukanController extends Controller
{
    public function create()
    {
        return view('public.masukan');
    }

    public function store(StoreMasukanRequest $request)
    {
        Masukan::create($request->validated());

        // AJAX (fetch) request → return JSON
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Masukan berhasil dikirim.']);
        }

        // Fallback jika JavaScript tidak aktif
        return redirect()->route('masukan.create')->with('masukan_terkirim', true);
    }
}
