<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    protected $table = 'layanan';

    protected $fillable = ['slug', 'nama', 'deskripsi', 'kategori_id', 'warna', 'terpublikasi'];

    protected function casts(): array
    {
        return [
            'terpublikasi' => 'boolean',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriLayanan::class, 'kategori_id');
    }

    public function berkas(): HasMany
    {
        return $this->hasMany(LayananBerkas::class, 'layanan_id')->orderBy('urutan');
    }

    public function langkah(): HasMany
    {
        return $this->hasMany(LayananLangkah::class, 'layanan_id')->orderBy('urutan');
    }

    public function scopeTerpublikasi($query)
    {
        return $query->where('terpublikasi', true);
    }
}
