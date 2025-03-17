<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

class Certificate extends Model
{
    use HasFactory, GenUid;

    protected $fillable = [
        'conversion_id',
        'user_id',
        'type',
        'attachment',
    ];

    protected $table = 'certificates';

    public function conversion()
    {
        return $this->belongsTo(Conversion::class);
    }
}
