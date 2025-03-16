<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

class Equipment extends Model
{
    use HasFactory, GenUid;

    protected $fillable = [
        'conversion_id',
        'name',
        'type',
        'specification',
        'brand',
        'status',
        'user_id',
    ];

    protected $table = 'equipments';

    public function conversion()
    {
        return $this->belongsTo(Conversion::class);
    }
}
