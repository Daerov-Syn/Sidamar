<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLayananRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nama'          => ['required', 'string', 'max:150'],
            'deskripsi'     => ['nullable', 'string', 'max:2000'],
            'kategori_id'   => ['required', 'integer', 'exists:kategori_layanan,id'],
            'warna'         => ['nullable', 'string'],
            'terpublikasi'  => ['nullable'],
            'berkas'        => ['nullable', 'array'],
            'langkah'       => ['nullable', 'array'],
        ];
    }
}
