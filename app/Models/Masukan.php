<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masukan extends Model
{
    protected $table = 'masukan';

    protected $fillable = ['nama', 'kontak', 'rating', 'isi', 'status'];
}
