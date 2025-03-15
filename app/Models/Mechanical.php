<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

class Mechanical extends Model
{
    use HasFactory, GenUid;

    protected $fillable = [
        'conversion_id',
        'name',
        'task',
        'user_id',
    ];

    public function conversion()
    {
        return $this->belongsTo(Conversion::class);
    }
}
