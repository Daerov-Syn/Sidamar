<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisKendaraan extends Model
{
    protected $table = 'jenis_kendaraan';

    protected $fillable = ['nama', 'kode'];

    public function tarifPajak(): HasMany
    {
        return $this->hasMany(TarifPajak::class, 'jenis_id');
    }
}
