<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'kode' => ['required', 'string', 'digits:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode OTP wajib diisi.',
            'kode.digits'   => 'Kode OTP harus 6 digit angka.',
        ];
    }
}
