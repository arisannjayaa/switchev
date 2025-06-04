<?php

namespace App\Services\Certificate;

use App\Exports\DataKonversiExport;
use App\Helpers\CertificateHelper;
use App\Helpers\Helper;
use App\Mail\MailSend;
use App\Models\Certificate;
use App\Models\TemplateCertificate;
use App\Repositories\Conversion\ConversionRepository;
use App\Repositories\TemplateCertificate\TemplateCertificateRepository;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Certificate\CertificateRepository;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;

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
     protected $mainRepository, $conversionRepository, $userRepository, $templateRepository;

    public function __construct(
        CertificateRepository $mainRepository,
        ConversionRepository $conversionRepository,
        UserRepository $userRepository,
        TemplateCertificateRepository $templateRepository
    )
    {
      $this->mainRepository = $mainRepository;
      $this->conversionRepository = $conversionRepository;
      $this->userRepository = $userRepository;
      $this->templateRepository = $templateRepository;
    }

    // Define your custom methods :)
    public function generate_certificate($conversion_id, $accreditation_type)
    {
        try {
            $conversion = $this->conversionRepository->find($conversion_id);

            if ($conversion->type == "Sepeda Motor" && $accreditation_type == "A") {
                $template = $this->templateRepository->find(TemplateCertificate::SERTIF_BENGKEL_TIPE_A);
                $templatePath = storage_path('app/'.$template->attachment);
            }

            if ($conversion->type == "Sepeda Motor" && $accreditation_type == "B") {
                $template = $this->templateRepository->find(TemplateCertificate::SERTIF_BENGKEL_TIPE_B);
                $templatePath = storage_path('app/'.$template->attachment);
            }

            if ($conversion->type == "Selain Sepeda Motor") {
                $template = $this->templateRepository->find(TemplateCertificate::SERTIF_SELAIN_SEPEDA_MOTOR);
                $templatePath = storage_path('app/'.$template->attachment);
            }

            $year_value = $accreditation_type == "A" ? "5 (lima) " : "4 (empat) ";

            $templateProcessor = new TemplateProcessor($templatePath);

            $templateProcessor->setValue('workshop', $conversion->workshop);
            $templateProcessor->setValue('address', $conversion->address);
            $templateProcessor->setValue('responsible', $conversion->person_responsible);
            $templateProcessor->setValue('year_l', strtoupper($year_value));
            $templateProcessor->setValue('reference_number', $conversion->certificate_code);

            $outputPath = storage_path('app/public/certificate/'."SERTIF-BK-".$conversion->id.'.docx');
            $templateProcessor->saveAs($outputPath);

            $result = [
                'download' => route('secure.file', ['path' => Helper::encrypt("certificate/"."SERTIF-BK-".$conversion->id.'.docx')]),
                'file_name' => Str::after($outputPath, 'certificate/')
            ];

            return $this->setResult($result)->setStatus(true)->setCode(200);
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function generate_sk($conversion_id, $accreditation_type)
    {
        try {
            $conversion = $this->conversionRepository->find($conversion_id);

            if ($conversion->type == "Sepeda Motor" && $accreditation_type == "A") {
                $template = $this->templateRepository->find(TemplateCertificate::SK_BENGKEL_TIPE_A);
                $templatePath = storage_path('app/'.$template->attachment);
            }

            if ($conversion->type == "Sepeda Motor" && $accreditation_type == "B") {
                $template = $this->templateRepository->find(TemplateCertificate::SK_BENGKEL_TIPE_B);
                $templatePath = storage_path('app/'.$template->attachment);
            }

            if ($conversion->type == "Selain Sepeda Motor") {
                $template = $this->templateRepository->find(TemplateCertificate::SK_SELAIN_SEPEDA_MOTOR);
                $templatePath = storage_path('app/'.$template->attachment);
            }

            $year_value = $accreditation_type == "A" ? "5 (lima)" : "4 (empat)";

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
            $tableMechanical->addCell(10000, ['valign' => 'center'])->addText("TUGAS/JABATAN", array_merge($fontStyle, ['bold' => true]), $paragraphStyle);

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


            $templateProcessor->setValue('workshop', $conversion->workshop);
            $templateProcessor->setValue('address', $conversion->address);
            $templateProcessor->setValue('year', $year_value);
            $templateProcessor->setValue('date', CertificateHelper::formatDateID(date('Y-m-d')));
            $templateProcessor->setValue('responsible', $conversion->person_responsible);
            $templateProcessor->setValue('reference_number', $conversion->sk_code);

            $outputPath = storage_path('app/public/certificate/'."SK-BK-".$conversion->id.'.docx');
            $templateProcessor->saveAs($outputPath);

            $result = [
                'download' => route('secure.file', ['path' => Helper::encrypt("certificate/"."SK-BK-".$conversion->id.'.docx')]),
                'file_name' => Str::after($outputPath, 'certificate/')
            ];

            return $this->setResult($result)->setStatus(true)->setCode(200);
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function upload_archive($data)
    {
        DB::beginTransaction();
        try {
            $certificate = $this->mainRepository->find($data['id']);

            if (@$data['sk_attachment']) {
                if (@$certificate->sk_attachment && str_contains($certificate->sk_attachment, 'certificate')) {
                    if (file_exists(storage_path('app/public/'.@$certificate->sk_attachment))) {
                        unlink(storage_path('app/public/'.@$certificate->sk_attachment));
                    }
                }

                // file surat keterangan
                $fileSKAttachment = $data['sk_attachment'];
                $originalNameApplicationLetter = $fileSKAttachment->getClientOriginalName();
                $extensionApplicationLetter = $fileSKAttachment->getClientOriginalExtension();
                $newFileNameApplicationLetter = 'Surat Keterangan - ' . uniqid() . '.' . $extensionApplicationLetter;
                $filePathApplicationLetter = $fileSKAttachment->storeAs('certificates', $newFileNameApplicationLetter, 'public');
                $data['sk_attachment'] = $filePathApplicationLetter;
            } else {
                $data['sk_attachment'] = $data['old_sk_attachment'];
                unset($data['old_sk_attachment']);
            }

            if (@$data['sft_attachment']) {
                if (@$certificate->sft_attachment && str_contains($certificate->sft_attachment, 'certificate')) {
                    if (file_exists(storage_path('app/public/'.@$certificate->sft_attachment))) {
                        unlink(storage_path('app/public/'.@$certificate->sft_attachment));
                    }
                }

                // file sertifikat
                $fileSKAttachment = $data['sft_attachment'];
                $originalNameApplicationLetter = $fileSKAttachment->getClientOriginalName();
                $extensionApplicationLetter = $fileSKAttachment->getClientOriginalExtension();
                $newFileNameApplicationLetter = 'Sertifikat - ' . uniqid() . '.' . $extensionApplicationLetter;
                $filePathApplicationLetter = $fileSKAttachment->storeAs('certificates', $newFileNameApplicationLetter, 'public');
                $data['sft_attachment'] = $filePathApplicationLetter;
            } else {
                $data['sft_attachment'] = $data['old_sft_attachment'];
                unset($data['old_sft_attachment']);
            }

            if (@$certificate) {
                $certificate->sft_attachment = $data['sft_attachment'];
                $certificate->sk_attachment = $data['sk_attachment'];
                $certificate->status = 'Selesai';
                $certificate->save();
                $this->conversionRepository->update($certificate->conversion_id,['certificate_id' => $certificate->id, 'message' => 'Bengkel Konversi Anda Resmi Terdaftar. Silahkan Download Dokumen Resmi']);
            }

//            if (!@$certificate) {
//                $data['status'] = 'Selesai';
//                $result = $this->mainRepository->create($data);
//                $this->conversionRepository->update($result->conversion_id,['certificate_id' => $result->id, 'message' => 'Bengkel Konversi Anda Resmi Terdaftar. Silahkan Download Dokumen Resmi']);
//            }


            $user = $this->userRepository->find($certificate->user_id);

            $mail['title'] = 'Selamat! Bengkel Konversi Anda Resmi Terdaftar. Silahkan Download Dokumen Resmi';
            $mail['message'] = '
                            <h2>⚡ Selamat! Bengkel Konversi Anda Resmi Terdaftar ⚡</h2>
                            <p>
                                Terima kasih telah bergabung sebagai bagian dari program konversi kendaraan listrik!
                                Bengkel Anda kini telah resmi terdaftar dan siap untuk memberikan layanan konversi kendaraan yang lebih ramah lingkungan.
                                Sebagai bukti pendaftaran, silakan unduh dokumen resmi melalui tombol di bawah ini:
                            </p>
                            <a href="' . route('secure.file', ['path' => Helper::encrypt($certificate->sft_attachment)]) . '" style="display: inline-block; padding: 12px 20px; margin: 10px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #28a745;">📜 Download Sertifikat</a>
                            <a href="' . route('secure.file', ['path' => Helper::encrypt($certificate->sk_attachment)]) . '" style="display: inline-block; padding: 12px 20px; margin: 10px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #007bff;">📄 Download Surat Keterangan</a>
                            <p style="margin-top: 20px; font-size: 14px; color: #777;">
                                🚀 Kami berharap bengkel Anda dapat memberikan kontribusi positif dalam percepatan kendaraan listrik di Indonesia.
                                Jika ada pertanyaan, silakan hubungi tim kami.
                                <br><br>
                                Salam hangat,
                                <br><strong>Tim Administrasi Program Konversi</strong>
                            </p>
                        ';

            Mail::to($user->email)->send(new MailSend($mail));

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => route('conversion.index')])
                ->setMessage("Unggah berkas berhasil dilakukan");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function verify_draft($id)
    {
        DB::beginTransaction();
        try {

            $id = Helper::decrypt($id);
            $result = $this->mainRepository->find($id);
            $result->status = 'Terverifikasi';
            $result->save();

            $redirect = redirect()->intended(URL::route('certificate.index'));

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()])
                ->setMessage("Berhasil memverifikasi draft");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function send_draft($conversion_id, $accreditation_type)
    {
        DB::beginTransaction();
        try {
            $certificate = $this->generate_certificate($conversion_id, $accreditation_type)->getResult();
            $sk = $this->generate_sk($conversion_id, $accreditation_type)->getResult();
            $result = $this->mainRepository->findByConversionId($conversion_id);
            $conversion = $this->conversionRepository->find($conversion_id);

            if ($result) {
                $result->sft_attachment = 'certificate/'. $certificate['file_name'];
                $result->sk_attachment = 'certificate/'. $sk['file_name'];
                $result->status = 'Draft';
                $result->save();
            }

            if (!$result) {
                $crtf =$this->mainRepository->create([
                    'user_id' => $conversion->user_id,
                    'conversion_id' => $conversion_id,
                    'sft_attachment' => 'certificate/'. $certificate['file_name'],
                    'sk_attachment' => 'certificate/'. $sk['file_name'],
                    'status' => 'Draft'
                ]);

                $conversion->certificate_id = $crtf->id;
                $conversion->save();
            }


            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("Berhasil membuat dan mengirimkan draft");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @return mixed
     */
    public function table()
    {
        return DataTables::of($this->mainRepository->table())
            ->addIndexColumn()
            ->addColumn('sk_file_name', function ($row) {
                $file =  Str::after($row->sk_attachment, 'certificate/');
                return preg_replace('/\.[^.]+$/', '', $file);
            })
            ->addColumn('sft_file_name', function ($row) {
                $file = Str::after($row->sft_attachment, 'certificate/');
                return preg_replace('/\.[^.]+$/', '', $file);
            })
            ->addColumn('action', function ($row) {
                if (auth()->user()->isAdmin()) {
                    $verificationMenu = '<a class="dropdown-item detail" href="'.route('certificate.show', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Lihat
                                </a>';
                }

                if (auth()->user()->isSuperAdmin()) {
                    $verificationMenu = '<a class="dropdown-item detail" href="'.route('certificate.verification.form', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Verifikasi
                                </a>';
                }
                $html = '<span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-circle-horizontal"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M8 12l0 .01" /><path d="M12 12l0 .01" /><path d="M16 12l0 .01" /></svg></button>
                              <div class="dropdown-menu dropdown-menu-end" style="">
                                    '.$verificationMenu.'
                              </div>
                            </span>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function export($data)
    {
        try {
            [$start, $end] = explode(' - ', $data['date_range']);
            $status = $data['status'];
            $type = $data['type'];

            $fileName = 'export_' . now()->format('Ymd_His') . '.xlsx';
            $filePath = storage_path("app/public/exports/{$fileName}");

            Excel::store(new DataKonversiExport($start, $end, $type, $status), "public/exports/{$fileName}");
            $result = [
                'download' => route('secure.file', ['path' => Helper::encrypt("exports/{$fileName}")]),
                'file_name' => $fileName
            ];
            return $this->setResult($result)
                ->setCode(200)
                ->setMessage("Berhasil mengexport data");
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
