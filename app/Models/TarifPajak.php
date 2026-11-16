<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TarifPajak extends Model
{
    protected $table = 'tarif_pajak';

    protected $fillable = ['jenis_id', 'tahun_min', 'tahun_max', 'nilai_dasar', 'tarif_persen'];

    protected function casts(): array
    {
        return [
            'nilai_dasar' => 'decimal:2',
            'tarif_persen' => 'decimal:2',
        ];
    }

    public function jenisKendaraan(): BelongsTo
    {
        return $this->belongsTo(JenisKendaraan::class, 'jenis_id');
    }
}
