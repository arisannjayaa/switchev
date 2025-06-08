<?php

namespace App\Services\TestLetter;

use App\Helpers\CertificateHelper;
use App\Helpers\Helper;
use App\Models\TemplateCertificate;
use App\Repositories\CertificateTestLetter\CertificateTestLetterRepository;
use App\Repositories\TemplateCertificate\TemplateCertificateRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\TestLetter\TestLetterRepository;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;

class TestLetterServiceImplement extends ServiceApi implements TestLetterService{

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
     protected $mainRepository, $certificateRepository, $templateRepository;

    public function __construct(TestLetterRepository $mainRepository, CertificateTestLetterRepository $certificateRepository, TemplateCertificateRepository $templateRepository)
    {
      $this->mainRepository = $mainRepository;
      $this->certificateRepository = $certificateRepository;
      $this->templateRepository = $templateRepository;
    }

    // Define your custom methods :)

    /**
     * @param $data
     * @return mixed
     */
    public function upsert_form($data)
    {
        DB::beginTransaction();
        try {
            $testLetter = $this->mainRepository->find($data['id']);
            $data['is_form_completed'] = 1;

            $attachments = [
                'sop_component_installation' => @$data['sop_component_installation'],
                'technical_drawing' => @$data['technical_drawing'],
                'conversion_workshop_certificate' => @$data['conversion_workshop_certificate'],
                'electrical_diagram' => @$data['electrical_diagram'],
                'photocopy_stnk' => @$data['photocopy_stnk'],
                'physical_inspection' => @$data['physical_inspection'],
                'test_report' => @$data['test_report'],
                'conversion_type_test_application_letter' => @$data['conversion_type_test_application_letter'],
            ];

            foreach ($attachments as $key => $value) {
                $fileName = $key;
                switch ($fileName) {
                    case 'sop_component_installation':
                        $fileName = "SOP_Pemasangan_Komponen_Konversi_";
                        break;
                    case 'technical_drawing':
                        $fileName = "Gambar_Teknik_";
                        break;
                    case 'conversion_workshop_certificate':
                        $fileName = "Sertifikat_Bengkel_Konversi_";
                        break;
                    case 'electrical_diagram':
                        $fileName = "Elektrikal_Diagram_";
                        break;
                    case 'photocopy_stnk':
                        $fileName = "Fotokopi_STNK_";
                        break;
                    case 'physical_inspection':
                        $fileName = "Fisik_Inspeksi_";
                        break;
                    case 'test_report':
                        $fileName = "Laporan_Pengujian_";
                        break;
                    case 'conversion_type_test_application_letter':
                        $fileName = "Surat_Permohonan_Uji_Tipe_Konversi_";
                        break;
                    default:
                        break;
                }

                if (@$data[$key]) {
                    if (@$testLetter->$key) {
                        if (file_exists(storage_path('app/public/'.@$testLetter->$key))) {
                            unlink(storage_path('app/public/'.@$testLetter->$key));
                        }
                    }

                    // file application letter
                    $file = $data[$key];
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $newFileName = $fileName . uniqid() . '.' . $extension;
                    $filePath = $file->storeAs('documents', $newFileName, 'public');
                    $data[$key] = $filePath;
                }

                if (@$data['old_'.$key]) {
                    $data[$key] = $data['old_'.$key];
                    unset($data['old_'.$key]);
                }
            }

            $data['user_id'] = auth()->user()->id;
            $data['is_verified'] = 0;
            $data['status'] = 'Menunggu Verifikasi';
            $data['step'] = 'verification_admin';
            $data['message'] = '<span>Mohon menunggu, dokumen Anda sedang diperiksa oleh admin.</span>';
            $lastQueue = $this->mainRepository->getLastQueue();
            $lastNumber = $lastQueue ? (int) $lastQueue->queue_number : 0;
            $newQueueNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

            if (@$data['id']) {
                $this->mainRepository->update($data['id'], $data);
                $redirect = redirect()->intended(URL::route('test.letter.show', ['id' => Helper::encrypt($data['id'])]));
            }

            if (!@$data['id']) {
                unset($data['id']);
                $data['code'] = Helper::generateTestLetterCode($newQueueNumber);
                $data['queue_number'] = $newQueueNumber;
                $result = $this->mainRepository->create($data);
                $redirect = redirect()->intended(URL::route('test.letter.show', ['id' => Helper::encrypt($result->id)]));
            }

            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function findAllByUserId()
    {
        try {
            $result = $this->mainRepository->findAllByUserId();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult($result);
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function table()
    {
        return DataTables::of($this->mainRepository->table())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $menuCertificate = '';
                $menuCertificate .= '<a class="dropdown-item" href="'.route('test.letter.show', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Detail <a/>';

                if ($row->step == 'bpljskb_uploaded' && @$row->certificate->status != 'Selesai') {
                    $menuCertificate .= '
                        <a class="dropdown-item generate" href="'.route('certificate.test.letter.certificate', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Buat Surat dan Sertifikat
                                </a>
                    ';
                }

                if ($row->step == 'create_spu') {
                    $menuCertificate .= '<a class="dropdown-item generate" href="'.route('test.letter.generate.spu', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Buat Surat Pengantar Uji
                                </a>';
                }

                if ($row->step == 'verification_admin') {
                    $menuCertificate .= '<a class="dropdown-item" href="'.route('test.letter.verification', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Verifikasi <a/>';
                }

                if ($row->step == 'verification_admin_srut') {
                    $menuCertificate .= '<a class="dropdown-item" href="'.route('test.letter.verification.srut', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Verifikasi SRUT <a/>';
                }

                if ($row->step == 'create_certificate_srut') {
                    $menuCertificate .= '<a class="dropdown-item" href="'.route('certificate.test.letter.certificate', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Buat Surat dan Sertifikat SRUT <a/>';
                }

                $html = '<span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-circle-horizontal"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M8 12l0 .01" /><path d="M12 12l0 .01" /><path d="M16 12l0 .01" /></svg></button>
                              <div class="dropdown-menu dropdown-menu-end" style="">
                                '.$menuCertificate.'
                              </div>
                            </span>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function approve($data)
    {
        DB::beginTransaction();
        try {
            $id = $data['id'];
            unset($data['id']);
            $data['status'] = "Terverifikasi";
            $data['step'] = "create_spu";
            $data['message'] = '<span>Berkas berhasil di verifikasi, tunggu admin untuk membuat Surat Pengantar Uji!</span>';

            $this->mainRepository->update($id, $data);
            $redirect = redirect()->intended(URL::route('test.letter.index'));
            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()])
                ->setMessage("Data berhasil di verifikasi");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @return \LaravelEasyRepository\Traits\ResultService|string
     */
    public function generate_physical_test_cover_letter()
    {
        try {
            $template = $this->templateRepository->find(TemplateCertificate::TEMPLATE_SPU);
            $templatePath = storage_path('app/'.$template->attachment);
            $templateProcessor = new TemplateProcessor($templatePath);

            $outputPath = storage_path('app/public/surat-pengantar/'.'SPU-'.uniqid().'.docx');
            $templateProcessor->saveAs($outputPath);
            return  Str::after($outputPath, 'app/public/');
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function upload_physical_test_letter($data)
    {
        DB::beginTransaction();
        try {
            $id = $data['id'];
            unset($data['id']);

            $testLetter = $this->mainRepository->find($id);

            // file physical_test_bpljskb
            $file = $data['physical_test_bpljskb'];
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newFileName = 'Hasil_Uji_Fisk_BPLJSKB_' . uniqid() . '.' . $extension;
            $filePath = $file->storeAs('sertifikat-uji', $newFileName, 'public');
            $data['physical_test_bpljskb'] = $filePath;
            $data['step'] = 'bpljskb_uploaded';
            $data['status'] = 'Berkas BPLJSKB sudah di Unggah';
            $data['message'] = '<span>Tunggu admin untuk membuat sertifikat dan berkas lainnya!</span>';

            $this->mainRepository->update($id, $data);

            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("File berhasil diupload");
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @return mixed
     */
    public function generate_spu($data)
    {
        try {
            $tableData = [
                [
                    "name" => $data['name_uji_rem'],
                    "amount" => $data['amount_uji_rem'],
                    "vol" => $data['vol_uji_rem'],
                    "total" => $data['total_uji_rem'],
                ],
                [
                    "name" => $data['name_uji_lampu_utama'],
                    "amount" => $data['amount_uji_lampu_utama'],
                    "vol" => $data['vol_uji_lampu_utama'],
                    "total" => $data['total_uji_lampu_utama'],
                ],
                [
                    "name" => $data['name_uji_klakson'],
                    "amount" => $data['amount_uji_klakson'],
                    "vol" => $data['vol_uji_klakson'],
                    "total" => $data['total_uji_klakson'],
                ],
                [
                    "name" => $data['name_uji_berat'],
                    "amount" => $data['amount_uji_berat'],
                    "vol" => $data['vol_uji_berat'],
                    "total" => $data['total_uji_berat'],
                ],
                [
                    "name" => $data['name_uji_dimensi'],
                    "amount" => $data['amount_uji_dimensi'],
                    "vol" => $data['vol_uji_dimensi'],
                    "total" => $data['total_uji_dimensi'],
                ],
                [
                    "name" => $data['name_uji_speedometer'],
                    "amount" => $data['amount_uji_speedometer'],
                    "vol" => $data['vol_uji_speedometer'],
                    "total" => $data['total_uji_speedometer'],
                ],
                [
                    "name" => $data['name_uji_kontruksi'],
                    "amount" => $data['amount_uji_kontruksi'],
                    "vol" => $data['vol_uji_kontruksi'],
                    "total" => $data['total_uji_kontruksi'],
                ],
                [
                    "name" => $data['name_uji_kebisingan'],
                    "amount" => $data['amount_uji_kebisingan'],
                    "vol" => $data['vol_uji_kebisingan'],
                    "total" => $data['total_uji_kebisingan'],
                ],
            ];

            if ($data['type'] == "Selain Sepeda Motor") {
                $tableData[] = [
                    "name" => $data['name_uji_side_slip'],
                    "amount" => $data['amount_uji_side_slip'],
                    "vol" => $data['vol_uji_side_slip'],
                    "total" => $data['total_uji_side_slip'],
                ];
                $tableData[] = [
                    "name" => $data['name_uji_radius_putar'],
                    "amount" => $data['amount_uji_radius_putar'],
                    "vol" => $data['vol_uji_radius_putar'],
                    "total" => $data['total_uji_radius_putar'],
                ];
            }


            $testLetter = $this->mainRepository->find($data['id']);
            $template = $this->templateRepository->find(TemplateCertificate::TEMPLATE_SPU);
            $templatePath = storage_path('app/'.$template->attachment);
            $templateProcessor = new TemplateProcessor($templatePath);

            $templateProcessor->setValue('workshop', $data['workshop']);
            $templateProcessor->setValue('nomor_surat', Helper::generateNomorSurat($testLetter->queue_number, "SPU"));
            $templateProcessor->setValue('date', CertificateHelper::formatDateID(date('Y-m-d')));
            $templateProcessor->setValue('vehicle_name', $data['vehicle_name']);
            $templateProcessor->setValue('brand_type', $data['brand_type']);
            $templateProcessor->setValue('type', $data['type']);
            $templateProcessor->setValue('vin_nik', $data['vin_nik']);
            $templateProcessor->setValue('vehicle_code', $data['vehicle_code']);
            $templateProcessor->setValue('fuel', $data['fuel']);

            $tableStyle = [
                'borderSize' => 4,
                'borderColor' => '000000',
                'cellMargin' => 10,
                'width' => 100,
            ];

            $fontStyle = [
                'name' => 'Arial',
                'size' => 11,
            ];

            $paragraphStyle = ['alignment' => 'center','spaceAfter' => 50,'spaceBefore' => 50];

            $tablebBiaya = new Table($tableStyle);


            $tablebBiaya->addRow();
            $tablebBiaya->addCell(2000, ['valign' => 'center'])->addText("NO", array_merge($fontStyle, ['bold' => false]), $paragraphStyle);
            $tablebBiaya->addCell(14000, ['valign' => 'center'])->addText("JENIS ITEM YANG DIUJI", array_merge($fontStyle, ['bold' => false]), $paragraphStyle);
            $tablebBiaya->addCell(10000, ['valign' => 'center'])->addText("TARIF/ITEM (Rp)", array_merge($fontStyle, ['bold' => false]), $paragraphStyle);
            $tablebBiaya->addCell(10000, ['valign' => 'center'])->addText("VOL", array_merge($fontStyle, ['bold' => false]), $paragraphStyle);
            $tablebBiaya->addCell(10000, ['valign' => 'center'])->addText("TARIF/RP", array_merge($fontStyle, ['bold' => false]), $paragraphStyle);

            $no = 1;

            foreach ($tableData as $tableRow) {
                $tablebBiaya->addRow();
                $tablebBiaya->addCell(1000)->addText($no, $fontStyle, $paragraphStyle);
                $tablebBiaya->addCell(14000)->addText($tableRow['name'], $fontStyle, $paragraphStyle);
                $tablebBiaya->addCell(10000)->addText($tableRow['amount'], $fontStyle, $paragraphStyle);
                $tablebBiaya->addCell(10000)->addText($tableRow['vol'], $fontStyle, $paragraphStyle);
                $tablebBiaya->addCell(10000)->addText($tableRow['total'], $fontStyle, $paragraphStyle);
                $no++;
            }

            $totalHarga = array_sum(array_map(function ($row) {
                return (int) str_replace(['Rp ', '.', ' '], '', $row['total']);
            }, $tableData));

            $tablebBiaya->addRow();

            $tablebBiaya->addCell(49000, ['gridSpan' => 4, 'valign' => 'center'])->addText(
                'Jumlah',
                array_merge($fontStyle, ['bold' => false]),
                ['alignment' => 'left','spaceAfter' => 50,'spaceBefore' => 50]
            );

            $tablebBiaya->addCell(10000, ['valign' => 'center'])->addText(
                Helper::formatToRupiah($totalHarga),
                array_merge($fontStyle, ['bold' => false]),
                $paragraphStyle
            );

            $templateProcessor->setComplexBlock('table_cost', $tablebBiaya);

            $outputPath = storage_path('app/public/surat-pengantar-uji/'."Surat_Pengantar_Uji_".uniqid().'.docx');
            $templateProcessor->saveAs($outputPath);

            $result = [
                'download' => route('secure.file', ['path' => Helper::encrypt("surat-pengantar-uji/".Str::after($outputPath, 'surat-pengantar-uji/'))]),
                'file_name' => Str::after($outputPath, 'surat-pengantar-uji/')
            ];

            return $this->setResult($result)->setStatus(true)->setCode(200);
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function send_spu($data)
    {
        DB::beginTransaction();
        try {
            $testLetter = $this->mainRepository->find($data['id']);
            // file physical_test_bpljskb
            $file = $data['spu_attachment'];
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newFileName = 'Surat_Pengantar_Uji_' . uniqid() . '.' . $extension;
            $filePath = $file->storeAs('surat-pengantar-uji', $newFileName, 'public');
            $testLetter->spu_attachment = $filePath;
            $testLetter->step = 'send_spu';
            $testLetter->status = "Menunggu Unggah Berkas BPLJSKB";
            $testLetter->message = '<span class="text-secondary text-left">Silakan lanjutkan pengujian fisik ke BPLJSKB dengan membawa Surat Pengantar Uji dan dokumen pendukung. Proses dilakukan sendiri oleh pemohon tanpa pendampingan admin.
                                         <a href="'.route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$testLetter->spu_attachment)]).'">Unduh Surat Pengantar Uji di sini</a></span>';
            $testLetter->save();

            $redirect = redirect()->intended(URL::route('test.letter.index'));
            DB::commit();
            return $this->setMessage("Berhasil mengirimkan SPU")
                ->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function upsert_permohonan_srut_form($data)
    {
        DB::beginTransaction();
        try {
            $testLetter = $this->mainRepository->find($data['id']);

            $attachments = [
                'permohonan_srut' => @$data['permohonan_srut'],
                'quality_control' => @$data['quality_control'],
            ];

            foreach ($attachments as $key => $value) {
                $fileName = $key;
                switch ($fileName) {
                    case 'permohonan_srut':
                        $fileName = "Permohonan_SRUT_";
                        break;
                    case 'quality_control':
                        $fileName = "Quality_Control_";
                        break;
                    default:
                        break;
                }

                if (@$data[$key]) {
                    if (@$testLetter->$key) {
                        if (file_exists(storage_path('app/public/'.@$testLetter->$key))) {
                            unlink(storage_path('app/public/'.@$testLetter->$key));
                        }
                    }

                    // file application letter
                    $file = $data[$key];
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $newFileName = $fileName . uniqid() . '.' . $extension;
                    $filePath = $file->storeAs('permohonan-srut', $newFileName, 'public');
                    $data[$key] = $filePath;
                }

                if (@$data['old_'.$key]) {
                    $data[$key] = $data['old_'.$key];
                    unset($data['old_'.$key]);
                }
            }

            $data['user_id'] = auth()->user()->id;
            $data['is_verified'] = 0;
            $data['status'] = 'Menunggu Verifikasi Permohonan SRUT';
            $data['step'] = 'verification_admin_srut';
            $data['message'] = '<span>Mohon menunggu, dokumen Anda sedang diperiksa oleh admin.</span>';
            $lastQueue = $this->mainRepository->getLastQueue();
            $lastNumber = $lastQueue ? (int) $lastQueue->queue_number : 0;
            $newQueueNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

            if (@$data['id']) {
                $this->mainRepository->update($data['id'], $data);
                $this->certificateRepository->update($testLetter->certificate->id, ['status' => 'Draft SRUT']);
            }

            if (!@$data['id']) {
                unset($data['id']);
                $data['code'] = Helper::generateTestLetterCode($newQueueNumber);
                $data['queue_number'] = $newQueueNumber;
                $this->mainRepository->create($data);
            }

            $redirect = redirect()->intended(URL::route('test.letter.index'));

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function approve_srut($data)
    {
        DB::beginTransaction();
        try {
            $id = $data['id'];
            unset($data['id']);
            $data['status'] = "SRUT Terverifikasi";
            $data['step'] = "create_certificate_srut";
            $data['message'] = '<span>Berkas berhasil di verifikasi, tunggu admin untuk membuat Sertifikat SRUT!</span>';

            $this->mainRepository->update($id, $data);
            $redirect = redirect()->intended(URL::route('test.letter.index'));
            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()])
                ->setMessage("SRUT berhasil di verifikasi");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function have_sut_form($data)
    {
        DB::beginTransaction();
        try {
            $testLetter = $this->mainRepository->find($data['id']);
            $data['is_form_completed'] = 1;
            $data['temp_type_test_attachment'] = @$data['type_test_attachment'];

            $attachments = [
                'sop_component_installation' => @$data['sop_component_installation'],
                'technical_drawing' => @$data['technical_drawing'],
                'conversion_workshop_certificate' => @$data['conversion_workshop_certificate'],
                'electrical_diagram' => @$data['electrical_diagram'],
                'photocopy_stnk' => @$data['photocopy_stnk'],
                'physical_inspection' => @$data['physical_inspection'],
                'test_report' => @$data['test_report'],
                'conversion_type_test_application_letter' => @$data['conversion_type_test_application_letter'],
                'temp_type_test_attachment' => @$data['temp_type_test_attachment'],
                'quality_control' => @$data['quality_control'],
            ];

            foreach ($attachments as $key => $value) {
                $fileName = $key;
                switch ($fileName) {
                    case 'sop_component_installation':
                        $fileName = "SOP_Pemasangan_Komponen_Konversi_";
                        break;
                    case 'technical_drawing':
                        $fileName = "Gambar_Teknik_";
                        break;
                    case 'conversion_workshop_certificate':
                        $fileName = "Sertifikat_Bengkel_Konversi_";
                        break;
                    case 'electrical_diagram':
                        $fileName = "Elektrikal_Diagram_";
                        break;
                    case 'photocopy_stnk':
                        $fileName = "Fotokopi_STNK_";
                        break;
                    case 'physical_inspection':
                        $fileName = "Fisik_Inspeksi_";
                        break;
                    case 'test_report':
                        $fileName = "Laporan_Pengujian_";
                        break;
                    case 'conversion_type_test_application_letter':
                        $fileName = "Surat_Permohonan_Uji_Tipe_Konversi_";
                        break;
                    case 'temp_type_test_attachment':
                        $fileName = "Sertifikat_SUT_";
                        break;
                    case 'quality_control':
                        $fileName = "Quality_Control_";
                        break;
                    default:
                        break;
                }

                if (@$data[$key]) {
                    if (@$testLetter->$key) {
                        if (file_exists(storage_path('app/public/'.@$testLetter->$key))) {
                            unlink(storage_path('app/public/'.@$testLetter->$key));
                        }
                    }

                    // file application letter
                    $file = $data[$key];
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $newFileName = $fileName . uniqid() . '.' . $extension;
                    $filePath = $file->storeAs('documents', $newFileName, 'public');
                    $data[$key] = $filePath;
                }

                if (@$data['old_'.$key]) {
                    $data[$key] = $data['old_'.$key];
                    unset($data['old_'.$key]);
                }
            }

            $data['user_id'] = auth()->user()->id;
            $data['is_verified'] = 0;
            $data['status'] = 'Menunggu Verifikasi';
            $data['step'] = 'verification_admin';
            $data['message'] = '<span>Mohon menunggu, dokumen Anda sedang diperiksa oleh admin.</span>';
            $lastQueue = $this->mainRepository->getLastQueue();
            $lastNumber = $lastQueue ? (int) $lastQueue->queue_number : 0;
            $newQueueNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

            if (@$data['id']) {
                $this->mainRepository->update($data['id'], $data);
                $redirect = redirect()->intended(URL::route('test.letter.show', ['id' => Helper::encrypt($data['id'])]));
            }

            if (!@$data['id']) {
                unset($data['id']);
                $data['code'] = Helper::generateTestLetterCode($newQueueNumber);
                $data['queue_number'] = $newQueueNumber;
                $result = $this->mainRepository->create($data);
                $redirect = redirect()->intended(URL::route('test.letter.show', ['id' => Helper::encrypt($result->id)]));
            }

            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function table_resume()
    {
        return DataTables::of($this->mainRepository->table_resume())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $menu = '<a class="dropdown-item show-modal-physical" href="javascript:void(0)" data-id="'.$row->id.'">
                              Upload Resume <a/>';
                $status = ($row->physical_test_bpljskb && $row->status) == 'Selesai' ? 'disabled' : '';
                $html = '<span class="dropdown">
                              <button '.$status.' class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-circle-horizontal"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M8 12l0 .01" /><path d="M12 12l0 .01" /><path d="M16 12l0 .01" /></svg></button>
                              <div class="dropdown-menu dropdown-menu-end" style="">
                                '.$menu.'
                              </div>
                            </span>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @return mixed
     */
    public function reject($data)
    {
        DB::beginTransaction();
        try {
            $test_letter = $this->mainRepository->find($data['id']);
            $data['step'] = 'rejected';
            $data['status'] = 'Di Tolak';

            $this->mainRepository->update($data['id'], $data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult([
                    'redirect' => route('test.letter.index'),])
                ->setMessage("Data berhasil ditolak karena tidak sesuai");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }
}
