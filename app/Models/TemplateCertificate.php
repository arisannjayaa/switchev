<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use LaravelEasyRepository\Traits\GenUid;

class TemplateCertificate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'attachment',
        'attachment_default',
        'is_change',
    ];

    const LAPORAN_QUALITY_CONTROL = 1;
    const SURAT_PERMOHONAN_SRUT = 2;
    const PERMOHONAN_UJI_TIPE_KONVERSI = 3;
    const SK_BENGKEL_TIPE_A = 4;
    const SK_BENGKEL_TIPE_B = 5;
    const SERTIF_BENGKEL_TIPE_B = 6;
    const SERTIF_BENGKEL_TIPE_A = 7;
    const SERTIF_SELAIN_SEPEDA_MOTOR = 8;
    const SK_KONVERSI_LAMPIRAN = 9;
    const SRUT_KONVERSI = 10;
    const SUT_KONVERSI = 11;
    const LAMPIRAN_HASIL_UJI = 12;
    const TEMPLATE_SPU = 13;

    const SK_SELAIN_SEPEDA_MOTOR = 14;
}
