<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KalkulasiRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'jenis_id'   => ['required', 'integer', 'exists:jenis_kendaraan,id'],
            'tahun'      => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'bulan_telat'=> ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_id.required'    => 'Jenis kendaraan wajib dipilih.',
            'jenis_id.exists'      => 'Jenis kendaraan tidak valid.',
            'tahun.required'       => 'Tahun kendaraan wajib diisi.',
            'tahun.min'            => 'Tahun tidak valid.',
            'tahun.max'            => 'Tahun tidak boleh melebihi tahun depan.',
            'bulan_telat.min'      => 'Lama keterlambatan tidak boleh negatif.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'error' => [
                'code'    => 'VALIDATION_ERROR',
                'message' => 'Data tidak valid.',
                'details' => $validator->errors(),
            ],
        ], 422));
    }
}
