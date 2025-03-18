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
        'zoom_mail_attempt',
        'field_mail_attempt',
        'step_1_completed',
        'step_2_completed',
        'step_3_completed',
        'step_4_completed',
        'certificate_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mechanicals()
    {
        return $this->hasMany(Mechanical::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
}
