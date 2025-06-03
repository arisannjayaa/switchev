<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\TemplateCertificate;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'guest'
        ]);

        Role::create([
            'name' => 'superadmin'
        ]);

        Role::create([
            'name' => 'BPLJSKB'
        ]);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password1'),
            'role_id' => 1,
            'status' => 'verified'
        ]);

        User::factory()->create([
            'name' => 'Member',
            'email' => 'member@mail.com',
            'password' => bcrypt('password1'),
            'role_id' => 2,
            'status' => 'verified'
        ]);

        User::factory()->create([
            'name' => 'Ari Sanjaya',
            'email' => 'wayanarisanjaya01@gmail.com',
            'password' => bcrypt('password1'),
            'role_id' => 2,
            'status' => 'verified'
        ]);

        User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('password1'),
            'role_id' => 3,
            'status' => 'verified'
        ]);

        $templates = [
            [
                'name' => 'Format Laporan Quality Control',
                'attachment' => 'templates/FORMAT_LAPORAN_QUALITY_CONTROL.docx',
                'attachment_default' => 'templates/FORMAT_LAPORAN_QUALITY_CONTROL.docx'
            ],
            [
                'name' => 'Format Surat Permohonan SRUT',
                'attachment' => 'templates/FORMAT_SURAT_PERMOHONAN_SRUT.docx',
                'attachment_default' => 'templates/FORMAT_SURAT_PERMOHONAN_SRUT.docx'
            ],
            [
                'name' => 'Surat Permohonan Uji Tipe Konversi',
                'attachment' => 'templates/SURAT_PERMOHONAN_UJI_TIPE_KONVERSI.docx',
                'attachment_default' => 'templates/SURAT_PERMOHONAN_UJI_TIPE_KONVERSI.docx'
            ],
            [
                'name' => 'SK Bengkel Tipe A',
                'attachment' => 'templates/SK_BENGKEL_TIPE_A.docx',
                'attachment_default' => 'templates/SK_BENGKEL_TIPE_A.docx'
            ],
            [
                'name' => 'SK Bengkel Tipe B',
                'attachment' => 'templates/SK_BENGKEL_TIPE_B.docx',
                'attachment_default' => 'templates/SK_BENGKEL_TIPE_B.docx'
            ],
            [
                'name' => 'Sertifikat Bengkel Tipe B',
                'attachment' => 'templates/SERTIF_BENGKEL_TIPE_B.docx',
                'attachment_default' => 'templates/SERTIF_BENGKEL_TIPE_B.docx'
            ],
            [
                'name' => 'Sertifikat Bengkel Tipe A',
                'attachment' => 'templates/SERTIF_BENGKEL_TIPE_A.docx',
                'attachment_default' => 'templates/SERTIF_BENGKEL_TIPE_A.docx'
            ],
            [
                'name' => 'Sertifikat Selain Sepeda Motor',
                'attachment' => 'templates/SERTIF_SELAIN_SEPEDA_MOTOR.docx',
                'attachment_default' => 'templates/SERTIF_SELAIN_SEPEDA_MOTOR.docx'
            ],
            [
                'name' => 'SK Konversi Lampiran',
                'attachment' => 'templates/SK_KONVERSI_LAMPIRAN.docx',
                'attachment_default' => 'templates/SK_KONVERSI_LAMPIRAN.docx'
            ],
            [
                'name' => 'SRUT Konversi',
                'attachment' => 'templates/SRUT_KONVERSI.docx',
                'attachment_default' => 'templates/SRUT_KONVERSI.docx'
            ],
            [
                'name' => 'SUT Konversi',
                'attachment' => 'templates/SUT_KONVERSI_NEW.docx',
                'attachment_default' => 'templates/SUT_KONVERSI.docx'
            ],
            [
                'name' => 'Lampiran Hasil Uji',
                'attachment' => 'templates/LAMPIRAN.docx',
                'attachment_default' => 'templates/LAMPIRAN.docx'
            ],
            [
                'name' => 'Template SPU',
                'attachment' => 'templates/Template_SPU.docx',
                'attachment_default' => 'templates/Template_SPU.docx'
            ],
        ];

        foreach ($templates as $template) {
            TemplateCertificate::create($template);
        }

    }
}
