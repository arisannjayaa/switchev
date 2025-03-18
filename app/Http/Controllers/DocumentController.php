<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentController extends Controller
{
    public function generate()
    {
        $templatePath = storage_path('app/templates/Certificate_Template.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('date_release', date('d F Y'));
        $templateProcessor->setValue('reference_number', 'Jl. Merdeka No. 10');
        $templateProcessor->setValue('workshop_name', 'Motor Jaya Abadi Nusa Dua');
        $templateProcessor->setValue('address', 'Jalan Raya Bypass Ngurah Rai, Jl. Merdeka No. 10');
        $templateProcessor->setValue('responsible', 'I Wayan Ari Sanjaya');

        $outputPath = storage_path('app/certificate/certificate-'.uniqid().'.docx');
        $templateProcessor->saveAs($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
