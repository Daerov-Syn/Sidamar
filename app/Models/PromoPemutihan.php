<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoPemutihan extends Model
{
    protected $table = 'promo_pemutihan';

    protected $fillable = ['nama', 'mulai', 'selesai', 'tipe_potongan', 'nilai', 'aktif'];

    protected function casts(): array
    {
        return [
            'mulai' => 'date',
            'selesai' => 'date',
            'nilai' => 'decimal:2',
            'aktif' => 'boolean',
        ];
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)
            ->where('mulai', '<=', now())
            ->where('selesai', '>=', now());
    }
}
