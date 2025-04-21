<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTestLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_letter_id',
        'user_id',
        'type_test_attachment',
        'registration_attachment',
        'sk_attachment',
        'status'
    ];

    protected $table = 'certificate_test_letters';

    public function test_letter()
    {
        return $this->belongsTo(TestLetter::class);
    }
}
