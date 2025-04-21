<?php

namespace App\Services\TestLetter;

use App\Helpers\CertificateHelper;
use App\Helpers\Helper;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\TestLetter\TestLetterRepository;
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
     protected $mainRepository;

    public function __construct(TestLetterRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
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

            if (!@$data['old_sop_component_installation']) {
                if (@$testLetter->sop_component_installation) {
                    if (file_exists(storage_path('app/public/'.@$testLetter->sop_component_installation))) {
                        unlink(storage_path('app/public/'.@$testLetter->sop_component_installation));
                    }
                }
                // file application letter
                $fileSopComponentInstallation = $data['sop_component_installation'];
                $originalNameSopComponentInstallation = $fileSopComponentInstallation->getClientOriginalName();
                $extensionSopComponentInstallation = $fileSopComponentInstallation->getClientOriginalExtension();
                $newFileNameSopComponentInstallation = 'SOP_Pemasangan_Komponen_Konversi_' . uniqid() . '.' . $extensionSopComponentInstallation;
                $filePathSopComponentInstallation = $fileSopComponentInstallation->storeAs('documents', $newFileNameSopComponentInstallation, 'public');
                $data['sop_component_installation'] = $filePathSopComponentInstallation;
            } else {
                $data['sop_component_installation'] = $data['old_sop_component_installation'];
                unset($data['old_sop_component_installation']);
            }

            if (!@$data['old_technical_drawing']) {
                if (@$testLetter->technical_drawing) {
                    if (file_exists(storage_path('app/public/'.@$testLetter->technical_drawing))) {
                        unlink(storage_path('app/public/'.@$testLetter->technical_drawing));
                    }
                }
                // file technical_drawing
                $fileTechnicalDrawing = $data['technical_drawing'];
                $originalNameTechnicalDrawing = $fileTechnicalDrawing->getClientOriginalName();
                $extensionTechnicalDrawing = $fileTechnicalDrawing->getClientOriginalExtension();
                $newFileNameTechnicalDrawing = 'Gambar_Teknik_' . uniqid() . '.' . $extensionTechnicalDrawing;
                $filePathTechnicalDrawing = $fileTechnicalDrawing->storeAs('documents', $newFileNameTechnicalDrawing, 'public');
                $data['technical_drawing'] = $filePathTechnicalDrawing;
            } else {
                $data['technical_drawing'] = $data['old_technical_drawing'];
                unset($data['old_technical_drawing']);
            }

            if (!@$data['old_conversion_workshop_certificate']) {
                if (@$testLetter->conversion_workshop_certificate) {
                    if (file_exists(storage_path('app/public/'.@$testLetter->conversion_workshop_certificate))) {
                        unlink(storage_path('app/public/'.@$testLetter->conversion_workshop_certificate));
                    }
                }
                // file conversion_workshop_certificate
                $fileConversionWorkshopCertificate = $data['conversion_workshop_certificate'];
                $originalNameConversionWorkshopCertificate = $fileConversionWorkshopCertificate->getClientOriginalName();
                $extensionConversionWorkshopCertificate = $fileConversionWorkshopCertificate->getClientOriginalExtension();
                $newFileNameConversionWorkshopCertificate = 'Sertifikat_Bengkel_Konversi_' . uniqid() . '.' . $extensionConversionWorkshopCertificate;
                $filePathConversionWorkshopCertificate = $fileConversionWorkshopCertificate->storeAs('documents', $newFileNameConversionWorkshopCertificate, 'public');
                $data['conversion_workshop_certificate'] = $filePathConversionWorkshopCertificate;
            } else {
                $data['conversion_workshop_certificate'] = $data['old_conversion_workshop_certificate'];
                unset($data['old_conversion_workshop_certificate']);
            }

            if (!@$data['old_electrical_diagram']) {
                if (@$testLetter->electrical_diagram) {
                    if (file_exists(storage_path('app/public/'.@$testLetter->electrical_diagram))) {
                        unlink(storage_path('app/public/'.@$testLetter->electrical_diagram));
                    }
                }
                // file electrical_diagram
                $fileElectricalDiagram = $data['electrical_diagram'];
                $originalNameElectricalDiagram = $fileElectricalDiagram->getClientOriginalName();
                $extensionElectricalDiagram = $fileElectricalDiagram->getClientOriginalExtension();
                $newFileNameElectricalDiagram = 'Elektrikal_Diagram_' . uniqid() . '.' . $extensionElectricalDiagram;
                $filePathElectricalDiagram = $fileElectricalDiagram->storeAs('documents', $newFileNameElectricalDiagram, 'public');
                $data['electrical_diagram'] = $filePathElectricalDiagram;
            } else {
                $data['electrical_diagram'] = $data['old_electrical_diagram'];
                unset($data['old_electrical_diagram']);
            }

            if (!@$data['old_photocopy_stnk']) {
                if (@$testLetter->photocopy_stnk) {
                    if (file_exists(storage_path('app/public/'.@$testLetter->photocopy_stnk))) {
                        unlink(storage_path('app/public/'.@$testLetter->photocopy_stnk));
                    }
                }
                // file photocopy_stnk
                $filePhotoCopySTNK = $data['photocopy_stnk'];
                $originalNamePhotoCopySTNK = $filePhotoCopySTNK->getClientOriginalName();
                $extensionPhotoCopySTNK = $filePhotoCopySTNK->getClientOriginalExtension();
                $newFileNamePhotoCopySTNK = 'Fotokopi_STNK_' . uniqid() . '.' . $extensionPhotoCopySTNK;
                $filePathPhotoCopySTNK = $filePhotoCopySTNK->storeAs('documents', $newFileNamePhotoCopySTNK, 'public');
                $data['photocopy_stnk'] = $filePathPhotoCopySTNK;
            } else {
                $data['photocopy_stnk'] = $data['old_photocopy_stnk'];
                unset($data['old_photocopy_stnk']);
            }

            if (!@$data['old_physical_inspection']) {
                if (@$testLetter->physical_inspection) {
                    if (file_exists(storage_path('app/public/'.@$testLetter->physical_inspection))) {
                        unlink(storage_path('app/public/'.@$testLetter->physical_inspection));
                    }
                }
                // file physical_inspection
                $filePhysicalInspection = $data['physical_inspection'];
                $originalNamePhysicalInspection = $filePhysicalInspection->getClientOriginalName();
                $extensionPhysicalInspection = $filePhysicalInspection->getClientOriginalExtension();
                $newFileNamePhysicalInspection = 'Fisik_Inspeksi_' . uniqid() . '.' . $extensionPhysicalInspection;
                $filePathPhysicalInspection = $filePhysicalInspection->storeAs('documents', $newFileNamePhysicalInspection, 'public');
                $data['physical_inspection'] = $filePathPhysicalInspection;
            } else {
                $data['physical_inspection'] = $data['old_physical_inspection'];
                unset($data['old_physical_inspection']);
            }

            if (!@$data['old_test_report']) {
                if (@$testLetter->test_report) {
                    if (file_exists(storage_path('app/public/'.@$testLetter->test_report))) {
                        unlink(storage_path('app/public/'.@$testLetter->test_report));
                    }
                }
                // file test_report
                $fileTestReport = $data['test_report'];
                $originalNameTestReport = $fileTestReport->getClientOriginalName();
                $extensionTestReport = $fileTestReport->getClientOriginalExtension();
                $newFileNameTestReport = 'Laporan_Pengujian_' . uniqid() . '.' . $extensionTestReport;
                $filePathTestReport = $fileTestReport->storeAs('documents', $newFileNameTestReport, 'public');
                $data['test_report'] = $filePathTestReport;
            } else {
                $data['test_report'] = $data['old_test_report'];
                unset($data['old_test_report']);
            }

            $data['user_id'] = auth()->user()->id;
            $data['code'] = Helper::generateTestLetterCode();
            $data['is_verified'] = 0;
            $data['status'] = 'Menunggu Verifikasi';

            if (@$data['id']) {
                $this->mainRepository->update($data['id'], $data);
            }

            if (!@$data['id']) {
                unset($data['id']);
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

                if ($row->physical_test_bpljskb != null) {
                    $menuCertificate = '
                        <a class="dropdown-item generate" href="'.route('test.letter.verification', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Buat Surat dan Sertifikat
                                </a>
                    ';
                }

                $html = '<span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-circle-horizontal"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M8 12l0 .01" /><path d="M12 12l0 .01" /><path d="M16 12l0 .01" /></svg></button>
                              <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item" href="'.route('test.letter.verification', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Verifikasi <a/>
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
            $path = $this->generate_physical_test_cover_letter();
            $data['physical_test_cover_letter']  = $path;

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
            $templatePath = storage_path('app/templates/Surat_Pengantar_Uji.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            $outputPath = storage_path('app/public/surat-pengantar/'.'SPUF-342986737.docx');
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

            $this->mainRepository->update($id, $data);

            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("File berhasil diupload");
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
