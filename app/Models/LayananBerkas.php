<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayananBerkas extends Model
{
    protected $table = 'layanan_berkas';

    protected $fillable = ['layanan_id', 'urutan', 'teks', 'fotokopi', 'wajib_asli', 'keterangan'];

    protected function casts(): array
    {
        return [
            'wajib_asli' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
