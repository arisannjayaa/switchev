<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversion_id',
        'user_id',
        'type',
        'sk_attachment',
        'sft_attachment',
        'status'
    ];

    protected $table = 'certificates';

    public function conversion()
    {
        return $this->hasOne(Conversion::class);
    }
}
