<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PromoPemutihan;

class PromoController extends Controller
{
    public function index()
    {
        $data = PromoPemutihan::aktif()
            ->get(['id', 'nama', 'mulai', 'selesai', 'tipe_potongan', 'nilai']);

        return response()->json(['data' => $data]);
    }
}
