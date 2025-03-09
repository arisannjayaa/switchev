<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

class Conversion extends Model
{
    use HasFactory, GenUid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'workshop',
        'address',
        'person_responsible',
        'whatapp_responsible',
        'application_letter',
        'technician_competency',
        'equipment',
        'sop',
        'wiring_diagram',
        'status',
        'step',
        'message',
    ];
}
