<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    const ADMIN = 1;
    const GUEST = 2;

    protected $fillable = [
        'name',
    ];

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }
}
