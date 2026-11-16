<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriLayanan extends Model
{
    protected $table = 'kategori_layanan';

    protected $fillable = ['nama', 'warna'];

    public function layanan(): HasMany
    {
        return $this->hasMany(Layanan::class, 'kategori_id');
    }
}
