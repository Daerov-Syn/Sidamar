<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayananLangkah extends Model
{
    protected $table = 'layanan_langkah';

    protected $fillable = ['layanan_id', 'urutan', 'teks', 'kode_loket', 'keterangan'];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
