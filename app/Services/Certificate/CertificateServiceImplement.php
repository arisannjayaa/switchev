<?php

namespace App\Services\Certificate;

use App\Helpers\CertificateHelper;
use App\Helpers\Helper;
use App\Repositories\Conversion\ConversionRepository;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Certificate\CertificateRepository;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

class CertificateServiceImplement extends ServiceApi implements CertificateService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(CertificateRepository $mainRepository, ConversionRepository $conversionRepository)
    {
      $this->mainRepository = $mainRepository;
      $this->conversionRepository = $conversionRepository;
    }

    // Define your custom methods :)
    public function generate_certificate($conversion_id)
    {
        try {
            $conversion = $this->conversionRepository->find($conversion_id);
            $templatePath = storage_path('app/templates/Certificate_Template.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            $templateProcessor->setValue('workshop_name', $conversion->workshop);
            $templateProcessor->setValue('address', $conversion->address);
            $templateProcessor->setValue('responsible', $conversion->person_responsible);
            $templateProcessor->setValue('reference_number', CertificateHelper::generateNomorSurat("STF"));

            $outputPath = storage_path('app/public/certificate/'.CertificateHelper::generateNomorSurat("STF", '-').'.docx');
            $templateProcessor->saveAs($outputPath);

            $result = [
                'download' => route('secure.file', ['path' => Helper::encrypt("certificate/".CertificateHelper::generateNomorSurat("STF", '-').'.docx')]),
                'file_name' => CertificateHelper::generateNomorSurat("STF", '-').'.docx'
            ];

            return $this->setResult($result)->setStatus(true)->setCode(200);
        } catch (Exception $e) {
            return $this->exceptionResponse($exception);
        }
    }

    public function generate_sk($conversion_id)
    {
        try {
            $conversion = $this->conversionRepository->find($conversion_id);
            $templatePath = storage_path('app/templates/SK_Template.docx');

            $templateProcessor = new TemplateProcessor($templatePath);

            $tableStyle = [
                'borderSize' => 4,
                'borderColor' => '000000',
                'cellMargin' => 10,
                'width' => 100,
            ];

            $fontStyle = [
                'name' => 'Bookman Old Style',
                'size' => 12,
            ];

            $paragraphStyle = ['alignment' => 'center'];

            $tableMechanical = new Table($tableStyle);


            $tableMechanical->addRow();
            $tableMechanical->addCell(1000, ['valign' => 'center'])->addText("NO", array_merge($fontStyle, ['bold' => true]), $paragraphStyle);
            $tableMechanical->addCell(4000, ['valign' => 'center'])->addText("NAMA", array_merge($fontStyle, ['bold' => true]), $paragraphStyle);
            $tableMechanical->addCell(10000, ['valign' => 'center'])->addText("URAIAN TUGAS", array_merge($fontStyle, ['bold' => true]), $paragraphStyle);

            $no = 1;
            foreach ($conversion->mechanicals as $mechanical) {
                $tableMechanical->addRow();
                $tableMechanical->addCell(1000)->addText($no, $fontStyle, $paragraphStyle);
                $tableMechanical->addCell(4000)->addText($mechanical->name, $fontStyle);
                $tableMechanical->addCell(10000)->addText($mechanical->task, $fontStyle);
                $no++;
            }

            $templateProcessor->setComplexBlock('table_mechanical', $tableMechanical);

            $tableEquipment = new Table($tableStyle);

            $tableEquipment->addRow();
            $tableEquipment->addCell(3000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText("JENIS", array_merge($fontStyle, ['bold' => true]), ['alignment' => 'center']);
            $tableEquipment->addCell(4000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText("NAMA ALAT", array_merge($fontStyle, ['bold' => true]), ['alignment' => 'center']);
            $tableEquipment->addCell(2000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText("MEREK", array_merge($fontStyle, ['bold' => true]), $paragraphStyle);
            $tableEquipment->addCell(4000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText("SPESIFIKASI", array_merge($fontStyle, ['bold' => true]), ['alignment' => 'center']);
            $tableEquipment->addCell(2000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText("KETERANGAN", array_merge($fontStyle, ['bold' => true]), $paragraphStyle);

            $groupedData = [];
            foreach ($conversion->equipments as $equipment) {
                $groupedData[$equipment->type][] = $equipment;
            }

            foreach ($groupedData as $type => $items) {
                $rowCount = count($items);
                $firstRow = true;

                foreach ($items as $equipment) {
                    $tableEquipment->addRow();

                    if ($firstRow) {
                        $tableEquipment->addCell(3000, ['valign' => 'center', 'vMerge' => 'restart', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText($type, $fontStyle, ['alignment' => 'left']);
                        $firstRow = false;
                    } else {
                        $tableEquipment->addCell(5000, ['vMerge' => 'continue']);
                    }

                    $tableEquipment->addCell(4000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText($equipment->name, $fontStyle);
                    $tableEquipment->addCell(2000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText($equipment->brand, $fontStyle);
                    $tableEquipment->addCell(4000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText($equipment->specification, $fontStyle);
                    $tableEquipment->addCell(2000, ['valign' => 'center', 'widthType' => TblWidth::TWIP, 'wrapText' => true])->addText($equipment->status, $fontStyle);
                }
            }

//            foreach ($conversion->equipments as $equipment) {
//                $tableEquipment->addRow();
//                $tableEquipment->addCell(3000)->addText($equipment->type, $fontStyle);
//                $tableEquipment->addCell(3000)->addText($equipment->name, $fontStyle);
//                $tableEquipment->addCell(2000)->addText($equipment->brand, $fontStyle);
//                $tableEquipment->addCell(4000)->addText($equipment->specification, $fontStyle);
//                $tableEquipment->addCell(2000)->addText($equipment->status, $fontStyle);
//            }

            $templateProcessor->setComplexBlock('table_equipment', $tableEquipment);


            $templateProcessor->setValue('workshop_name', $conversion->workshop);
            $templateProcessor->setValue('address', $conversion->address);
            $templateProcessor->setValue('date', CertificateHelper::formatDateID(date('Y-m-d')));
            $templateProcessor->setValue('responsible', $conversion->person_responsible);
            $templateProcessor->setValue('reference_number', CertificateHelper::generateNomorSurat("SK"));

            $outputPath = storage_path('app/public/certificate/'.CertificateHelper::generateNomorSurat("SK", '-').'.docx');
            $templateProcessor->saveAs($outputPath);

            $result = [
                'download' => route('secure.file', ['path' => Helper::encrypt("certificate/".CertificateHelper::generateNomorSurat("SK", '-').'.docx')]),
                'file_name' => CertificateHelper::generateNomorSurat("SK", '-').'.docx'
            ];

            return $this->setResult($result)->setStatus(true)->setCode(200);
        } catch (Exception $e) {
            return $this->exceptionResponse($exception);
        }
    }
}
