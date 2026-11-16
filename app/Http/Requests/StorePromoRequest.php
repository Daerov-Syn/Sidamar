<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nama'          => ['required', 'string', 'max:150'],
            'mulai'         => ['required', 'date'],
            'selesai'       => ['required', 'date', 'after_or_equal:mulai'],
            'tipe_potongan' => ['required', 'in:persen,tetap'],
            'nilai'         => ['required', 'numeric', 'min:0'],
            'aktif'         => ['nullable', 'boolean'],
        ];
    }
}
