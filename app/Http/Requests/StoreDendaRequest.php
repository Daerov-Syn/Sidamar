<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDendaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'periode_min_bulan' => ['required', 'integer', 'min:0'],
            'periode_max_bulan' => ['required', 'integer', 'min:0', 'gte:periode_min_bulan'],
            'tipe'              => ['required', 'in:persen,tetap'],
            'nilai'             => ['required', 'numeric', 'min:0'],
        ];
    }
}
