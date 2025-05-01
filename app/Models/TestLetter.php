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
        'brand',
        'type',
        'type_vehicle',
        'trademark',
        'country_of_origin',
        'variant',
        'allotment',
        'transmission',
        'drive_system',
        'chassis',
        'chassis_place_number',
        'chassis_method_number',
        'pre_conversion_engine',
        'pre_conversion_engine_place_number',
        'pre_conversion_engine_method_number',
        'post_conversion_engine',
        'post_conversion_engine_place_number',
        'post_conversion_engine_method_number',
        'drive_motor',
        'fuel_system',
        'vehicle_dimension',
        'axis_configuration',
        'tire_size',
        'vehicle_weight',
        'power_forwarder',
        'braking_system',
        'suspension_system',
        'other',
        'is_form_completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificate_test_letter()
    {
        return $this->hasOne(CertificateTestLetter::class);
    }
}
