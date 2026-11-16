<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasukanRequest;
use App\Models\Masukan;

class MasukanController extends Controller
{
    public function store(StoreMasukanRequest $request)
    {
        $masukan = Masukan::create($request->validated());

        return response()->json([
            'data'    => ['id' => $masukan->id],
            'message' => 'Masukan berhasil dikirim. Terima kasih!',
        ], 201);
    }
}
