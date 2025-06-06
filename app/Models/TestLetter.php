<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

class TestLetter extends Model
{
    use HasFactory, GenUid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'workshop_type',
        'sop_component_installation',
        'technical_drawing',
        'conversion_workshop_certificate',
        'electrical_diagram',
        'photocopy_stnk',
        'physical_inspection',
        'conversion_type_test_application_letter',
        'test_report',
        'physical_test_bpljskb',
        'status',
        'code',
        'is_verified',
        'physical_test_cover_letter',
        'responsible_person',
        'telephone',
        'address',
        'workshop',
        'is_form_completed',
        'step',
        'spu',
        'message',
        'queue_number',
        'permohonan_srut',
        'quality_control',
        'temp_type_test_attachment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificate()
    {
        return $this->hasOne(CertificateTestLetter::class);
    }
}
