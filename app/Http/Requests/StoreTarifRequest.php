<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarifRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'jenis_id'     => ['required', 'integer', 'exists:jenis_kendaraan,id'],
            'tahun_min'    => ['required', 'integer', 'min:1900', 'max:2100'],
            'tahun_max'    => ['required', 'integer', 'min:1900', 'max:2100', 'gte:tahun_min'],
            'nilai_dasar'  => ['required', 'numeric', 'min:0'],
            'tarif_persen' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
