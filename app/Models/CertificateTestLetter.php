<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTestLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_letter_id',
        'brand',
        'vehicle_type',
        'type',
        'purpose_vehicle',
        'chassis',
        'electric_motor_number',
        'year_build',
        'axis_1_2',
        'axis_2_3',
        'axis_3_4',
        'width_total',
        'length_total',
        'height_total',
        'julur_front',
        'julur_rear',
        'power_max',
        'battery_max',
        'tire_axis_1',
        'tire_axis_2',
        'tire_axis_3',
        'tire_axis_4',
        'jbb',
        'empty_weight',
        'jbi',
        'carry_capacity',
        'road_class',
        'date_bpljskb',
        'place_test_bpljskb',
        'date_sut',
        'date_srut',
        'date_sk',
        'qr_code',
        'type_test_attachment',
        'registration_attachment',
        'sk_attachment',
        'certificate_attachment',
        'is_form_completed',
        'status',
        'user_id',
        'machine',
        'goods_capacity',
        'testing',
        'regarding',
    ];

    protected $table = 'certificate_test_letters';

    public function test_letter()
    {
        return $this->belongsTo(TestLetter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
