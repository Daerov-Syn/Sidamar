<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = ['username', 'password', 'email'];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function otps(): HasMany
    {
        return $this->hasMany(Otp::class, 'admin_id');
    }
}
