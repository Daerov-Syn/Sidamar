<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasukanRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    /**
     * Gabungkan kritik + saran menjadi kolom `isi` sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        $kritik = trim(strip_tags($this->input('kritik', '')));
        $saran  = trim(strip_tags($this->input('saran', '')));

        // Rakit kolom `isi` dari kritik dan saran
        $parts = [];
        if ($kritik !== '') {
            $parts[] = "Kritik: {$kritik}";
        }
        if ($saran !== '') {
            $parts[] = "Saran: {$saran}";
        }
        $isi = implode('. ', $parts);

        // Rating default 5 jika dikosongkan (karena opsional pada UI)
        $rating = (int) $this->input('rating', 5);
        if ($rating < 1 || $rating > 5) {
            $rating = 5;
        }

        $this->merge([
            'isi'    => $isi,
            'rating' => $rating,
            'nama'   => $this->filled('nama') ? trim(strip_tags($this->input('nama'))) : null,
            'kontak' => $this->filled('kontak') ? trim(strip_tags($this->input('kontak'))) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama'   => ['nullable', 'string', 'max:100'],
            'kontak' => ['nullable', 'string', 'max:150'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'isi'    => ['required', 'string', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'isi.required' => 'Mohon isi minimal salah satu dari Kritik atau Saran.',
            'isi.min'      => 'Masukan terlalu singkat, minimal 5 karakter.',
            'rating.required' => 'Penilaian layanan diperlukan.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
        ];
    }
}
