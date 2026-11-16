<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AturanDenda extends Model
{
    protected $table = 'aturan_denda';

    protected $fillable = ['periode_min_bulan', 'periode_max_bulan', 'tipe', 'nilai'];

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:2',
        ];
    }
}
