<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\JenisKendaraan;

class JenisKendaraanController extends Controller
{
    public function index()
    {
        $data = JenisKendaraan::orderBy('nama')->get(['id', 'nama', 'kode']);
        return response()->json(['data' => $data]);
    }
}
