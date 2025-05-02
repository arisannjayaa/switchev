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

            if (@$data['id']) {
                $this->mainRepository->update($data['id'], $data);
            }

            if (!@$data['id']) {
                unset($data['id']);
                $data['code'] = Helper::generateTestLetterCode();
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
                        <a class="dropdown-item generate" href="'.route('test.letter.certificate', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Buat Surat dan Sertifikat
                                </a>
                    ';
                }

                if ($row->step == 'create_spu') {
                    $menuCertificate .= '<a class="dropdown-item generate" href="'.route('test.letter.generate.spu', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Buat Surat Pengantar Uji
                                </a>';
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
            $data['step'] = "create_spu";
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
