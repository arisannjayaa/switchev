<?php

namespace App\Services\CertificateTestLetter;

use App\Helpers\CertificateHelper;
use App\Helpers\Helper;
use App\Mail\MailSend;
use App\Repositories\TestLetter\TestLetterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\CertificateTestLetter\CertificateTestLetterRepository;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class CertificateTestLetterServiceImplement extends ServiceApi implements CertificateTestLetterService{

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
     protected $mainRepository, $testLetterRepository;

    public function __construct(CertificateTestLetterRepository $mainRepository, TestLetterRepository $testLetterRepository)
    {
      $this->mainRepository = $mainRepository;
      $this->testLetterRepository = $testLetterRepository;
    }

    /**
     * @param $test_letter_id
     * @return mixed
     */
    public function generate_sk($test_letter_id)
    {
        $testLetter = $this->testLetterRepository->find($test_letter_id);
        $templatePath =  storage_path('app/templates/SK_KONVERSI.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('nomor_surat', Helper::generateNomorSurat($testLetter->queue_number, "SK"));
        $templateProcessor->setValue('brand', $testLetter->certificate->brand);
        $templateProcessor->setValue('type', $testLetter->certificate->type);
        $templateProcessor->setValue('vehicle_type', $testLetter->certificate->vehicle_type);
        $templateProcessor->setValue('brand_l', strtoupper($testLetter->certificate->brand));
        $templateProcessor->setValue('type_l', strtoupper($testLetter->certificate->type));
        $templateProcessor->setValue('vehicle_type_l', strtoupper($testLetter->certificate->vehicle_type));
        $templateProcessor->setValue('date', CertificateHelper::formatDateID($testLetter->certificate->date_sk) ?? '');

        $outputPath = storage_path('app/public/sk-srut-sut/'."Surat_Keterangan_".$test_letter_id.'.docx');
        if (File::exists($outputPath)) {
            File::delete($outputPath);
        }
        $templateProcessor->saveAs($outputPath);

        $result = [
            'download' => route('secure.file', ['path' => Helper::encrypt("sk-srut-sut/".Str::after($outputPath, 'sk-srut-sut/'))]),
            'file_name' => Str::after($outputPath, 'sk-srut-sut/')
        ];

        return $this->setResult($result)->setStatus(true)->setCode(200);
    }

    /**
     * @param $test_letter_id
     * @return mixed
     */
    public function generate_certificate_srut($test_letter_id)
    {
        $testLetter = $this->testLetterRepository->find($test_letter_id);
        $templatePath =  storage_path('app/templates/SRUT_KONVERSI.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('brand', $testLetter->certificate->brand);
        $templateProcessor->setValue('nomor_surat', Helper::generateNomorSurat($testLetter->queue_number, "SRUT"));
        $templateProcessor->setValue('goods_capacity', $testLetter->certificate->goods_capacity);
        $templateProcessor->setValue('type', $testLetter->certificate->type);
        $templateProcessor->setValue('variant', $testLetter->certificate->type);
        $templateProcessor->setValue('vehicle_type', $testLetter->certificate->vehicle_type);
        $templateProcessor->setValue('purpose_vehicle', $testLetter->certificate->purpose_vehicle);
        $templateProcessor->setValue('chassis', $testLetter->certificate->chassis);
        $templateProcessor->setValue('machine', $testLetter->certificate->machine);
        $templateProcessor->setValue('responsible_person', $testLetter->responsible_person);
        $templateProcessor->setValue('axis_1_2', $testLetter->certificate->axis_1_2 ?? '');
        $templateProcessor->setValue('axis_2_3', $testLetter->certificate->axis_2_3 ?? '');
        $templateProcessor->setValue('axis_3_4', $testLetter->certificate->axis_3_4 ?? '');
        $templateProcessor->setValue('width_total', $testLetter->certificate->width_total ?? '');
        $templateProcessor->setValue('length_total', $testLetter->certificate->length_total ?? '');
        $templateProcessor->setValue('length_total', $testLetter->certificate->length_total ?? '');
        $templateProcessor->setValue('height_total', $testLetter->certificate->height_total ?? '');
        $templateProcessor->setValue('julur_front', $testLetter->certificate->julur_front ?? '');
        $templateProcessor->setValue('julur_rear', $testLetter->certificate->julur_rear ?? '');
        $templateProcessor->setValue('power_max', $testLetter->certificate->power_max ?? '');
        $templateProcessor->setValue('battery_max', $testLetter->certificate->battery_max ?? '');
        $templateProcessor->setValue('tire_axis_1', $testLetter->certificate->tire_axis_1 ?? '');
        $templateProcessor->setValue('tire_axis_2', $testLetter->certificate->tire_axis_2 ?? '');
        $templateProcessor->setValue('tire_axis_3', $testLetter->certificate->tire_axis_3 ?? '');
        $templateProcessor->setValue('tire_axis_4', $testLetter->certificate->tire_axis_4 ?? '');
        $templateProcessor->setValue('jbb', $testLetter->certificate->jbb ?? '');
        $templateProcessor->setValue('empty_weight', $testLetter->certificate->empty_weight ?? '');
        $templateProcessor->setValue('jbi', $testLetter->certificate->jbi ?? '');
        $templateProcessor->setValue('carry_capacity', $testLetter->certificate->carry_capacity ?? '');
        $templateProcessor->setValue('road_class', $testLetter->certificate->road_class ?? '');
        $templateProcessor->setValue('date', CertificateHelper::formatDateID($testLetter->certificate->date_srut) ?? '');

        $qrCodeName = "qrcode_{$test_letter_id}.png";
        $qrCodePath = storage_path("app/public/qr/Sertifikat_SRUT_{$qrCodeName}");

        if (File::exists($qrCodePath)) {
            File::delete($qrCodePath);
        }

        $outputPath = storage_path('app/public/certificate-srut/'."Sertifikat_SRUT_".$test_letter_id.'.docx');
        $relativePath = Str::after($outputPath, 'certificate-srut/');
        $pdfRelativePath = Str::replaceLast('.docx', '.pdf', $relativePath);
        $qrData = route('qr.secure.file', ['path' => Helper::encrypt("certificate-srut/".$pdfRelativePath)]);
        QrCode::format('png')->size(150)->generate($qrData, $qrCodePath);

        $templateProcessor->setImageValue('qr_code', [
            'path' => $qrCodePath,
            'width' => 120,
            'height' => 120,
        ]);

        if (File::exists($outputPath)) {
            File::delete($outputPath);
        }

        $templateProcessor->saveAs($outputPath);

        $result = [
            'download' => route('secure.file', ['path' => Helper::encrypt("certificate-srut/".Str::after($outputPath, 'certificate-srut/'))]),
            'file_name' => Str::after($outputPath, 'certificate-srut/')
        ];

        return $this->setResult($result)->setStatus(true)->setCode(200);
    }

    /**
     * @param $test_letter_id
     * @return mixed
     */
    public function generate_certificate_sut($test_letter_id)
    {
        $testLetter = $this->testLetterRepository->find($test_letter_id);
        $testing = json_decode($testLetter->certificate->testing);
        $templatePath =  storage_path('app/templates/SUT_KONVERSI_NEW.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('workshop', $testLetter->workshop);
        $templateProcessor->setValue('address', $testLetter->address);
        $templateProcessor->setValue('brand', $testLetter->certificate->brand);
        $templateProcessor->setValue('goods_capacity', $testLetter->certificate->goods_capacity);
        $templateProcessor->setValue('type', $testLetter->certificate->type);
        $templateProcessor->setValue('vehicle_type', $testLetter->certificate->vehicle_type);
        $templateProcessor->setValue('purpose_vehicle', $testLetter->certificate->purpose_vehicle);
        $templateProcessor->setValue('chassis', $testLetter->certificate->chassis);
        $templateProcessor->setValue('electric_motor_number', $testLetter->certificate->electric_motor_number);
        $templateProcessor->setValue('year_build', $testLetter->certificate->year_build);
        $templateProcessor->setValue('responsible_person', $testLetter->responsible_person);
        $templateProcessor->setValue('axis_1_2', $testLetter->certificate->axis_1_2 ?? '');
        $templateProcessor->setValue('axis_2_3', $testLetter->certificate->axis_2_3 ?? '');
        $templateProcessor->setValue('axis_3_4', $testLetter->certificate->axis_3_4 ?? '');
        $templateProcessor->setValue('width_total', $testLetter->certificate->width_total ?? '');
        $templateProcessor->setValue('length_total', $testLetter->certificate->length_total ?? '');
        $templateProcessor->setValue('length_total', $testLetter->certificate->length_total ?? '');
        $templateProcessor->setValue('height_total', $testLetter->certificate->height_total ?? '');
        $templateProcessor->setValue('julur_front', $testLetter->certificate->julur_front ?? '');
        $templateProcessor->setValue('julur_rear', $testLetter->certificate->julur_rear ?? '');
        $templateProcessor->setValue('power_max', $testLetter->certificate->power_max ?? '');
        $templateProcessor->setValue('battery_max', $testLetter->certificate->battery_max ?? '');
        $templateProcessor->setValue('tire_axis_1', $testLetter->certificate->tire_axis_1 ?? '');
        $templateProcessor->setValue('tire_axis_2', $testLetter->certificate->tire_axis_2 ?? '');
        $templateProcessor->setValue('tire_axis_3', $testLetter->certificate->tire_axis_3 ?? '');
        $templateProcessor->setValue('tire_axis_4', $testLetter->certificate->tire_axis_4 ?? '');
        $templateProcessor->setValue('jbb', $testLetter->certificate->jbb ?? '');
        $templateProcessor->setValue('empty_weight', $testLetter->certificate->empty_weight ?? '');
        $templateProcessor->setValue('jbi', $testLetter->certificate->jbi ?? '');
        $templateProcessor->setValue('carry_capacity', $testLetter->certificate->carry_capacity ?? '');
        $templateProcessor->setValue('road_class', $testLetter->certificate->road_class ?? '');
        $templateProcessor->setValue('date', CertificateHelper::formatDateID($testLetter->certificate->date_sut) ?? '');
        $templateProcessor->setValue('place_test_bpljskb', $testLetter->certificate->place_test_bpljskb ?? '');
        $templateProcessor->setValue('date_bpljskb',  CertificateHelper::formatDateID($testLetter->certificate->date_bpljskb) ?? '');
//        lampiran
        $templateProcessor->setValue('brand_l', strtoupper($testLetter->certificate->brand));
        $templateProcessor->setValue('type_l', strtoupper($testLetter->certificate->type));
        $templateProcessor->setValue('vehicle_type_l', strtoupper($testLetter->certificate->vehicle_type));
        $templateProcessor->setValue('rem_belakang', $testing[0]->a->hasil_uji->belakang ?? '');
        $templateProcessor->setValue('rem_depan', $testing[0]->a->hasil_uji->depan ?? '');
        $templateProcessor->setValue('rem_a_ambang_batas', $testing[0]->a->ambang_batas ?? '');
        $templateProcessor->setValue('nomor_surat', Helper::generateNomorSurat($testLetter->queue_number, "SUT"));
        $templateProcessor->setValue('rem_a_keterangan', $testing[0]->a->keterangan ?? '');
        $templateProcessor->setValue('lampu_a_hasil_uji', $testing[1]->a->hasil_uji ?? '');
        $templateProcessor->setValue('lampu_b_hasil_uji', $testing[1]->b->hasil_uji ?? '');
        $templateProcessor->setValue('lampu_a_ambang_batas', $testing[1]->a->ambang_batas ?? '');
        $templateProcessor->setValue('lampu_a_keterangan', $testing[1]->a->keterangan ?? '');
        $templateProcessor->setValue('lampu_b_keterangan', $testing[1]->b->keterangan ?? '');
        $templateProcessor->setValue('lampu_b_penyimpangan_kanan', $testing[1]->b->peyimpangan_kanan ?? '');
        $templateProcessor->setValue('lampu_b_penyimpangan_kiri', $testing[1]->b->peyimpangan_kiri ?? '');
        $templateProcessor->setValue('klakson_hasil_uji', $testing[2]->a->hasil_uji ?? '');
        $templateProcessor->setValue('klakson_ambang_batas', $testing[2]->a->ambang_batas ?? '');
        $templateProcessor->setValue('klakson_keterangan', $testing[2]->a->keterangan ?? '');
        $templateProcessor->setValue('berat_data_teknis', $testing[3]->a->data_teknis ?? '');
        $templateProcessor->setValue('berat_hasil_uji', $testing[3]->a->hasil_uji ?? '');
        $templateProcessor->setValue('berat_ambang_batas', $testing[3]->a->ambang_batas ?? '');
        $templateProcessor->setValue('berat_keterangan', $testing[3]->a->keterangan ?? '');
        $templateProcessor->setValue('speedometer_data_teknis', $testing[4]->a->data_teknis ?? '');
        $templateProcessor->setValue('speedometer_hasil_uji', $testing[4]->a->hasil_uji ?? '');
        $templateProcessor->setValue('speedometer_ambang_batas', $testing[4]->a->ambang_batas ?? '');
        $templateProcessor->setValue('speedometer_keterangan', $testing[4]->a->keterangan ?? '');

        $templateProcessor->setValue('6_a_data_teknis', $testing[5]->a->data_teknis ?? '');
        $templateProcessor->setValue('6_a_hasil_uji', $testing[5]->a->hasil_uji ?? '');
        $templateProcessor->setValue('6_a_ambang_batas', $testing[5]->a->ambang_batas ?? '');
        $templateProcessor->setValue('6_a_keterangan', $testing[5]->a->keterangan ?? '');
        $templateProcessor->setValue('6_b_data_teknis', $testing[5]->b->data_teknis ?? '');
        $templateProcessor->setValue('6_b_hasil_uji', $testing[5]->b->hasil_uji ?? '');
        $templateProcessor->setValue('6_b_ambang_batas', $testing[5]->b->ambang_batas ?? '');
        $templateProcessor->setValue('6_b_keterangan', $testing[5]->b->keterangan ?? '');
        $templateProcessor->setValue('6_c_data_teknis', $testing[5]->c->data_teknis ?? '');
        $templateProcessor->setValue('6_c_hasil_uji', $testing[5]->c->hasil_uji ?? '');
        $templateProcessor->setValue('6_c_ambang_batas', $testing[5]->c->ambang_batas ?? '');
        $templateProcessor->setValue('6_c_keterangan', $testing[5]->c->keterangan ?? '');
        $templateProcessor->setValue('6_d_data_teknis', $testing[5]->d->data_teknis ?? '');
        $templateProcessor->setValue('6_d_hasil_uji', $testing[5]->d->hasil_uji ?? '');
        $templateProcessor->setValue('6_d_ambang_batas', $testing[5]->d->ambang_batas ?? '');
        $templateProcessor->setValue('6_d_keterangan', $testing[5]->d->keterangan ?? '');
        $templateProcessor->setValue('6_e_data_teknis', $testing[5]->e->data_teknis ?? '');
        $templateProcessor->setValue('6_e_hasil_uji', $testing[5]->e->hasil_uji ?? '');
        $templateProcessor->setValue('6_e_ambang_batas', $testing[5]->e->ambang_batas ?? '');
        $templateProcessor->setValue('6_e_keterangan', $testing[5]->e->keterangan ?? '');
        $templateProcessor->setValue('6_f_data_teknis', $testing[5]->f->data_teknis ?? '');
        $templateProcessor->setValue('6_f_hasil_uji', $testing[5]->f->hasil_uji ?? '');
        $templateProcessor->setValue('6_f_ambang_batas', $testing[5]->f->ambang_batas ?? '');
        $templateProcessor->setValue('6_f_keterangan', $testing[5]->f->keterangan ?? '');
        $templateProcessor->setValue('6_g_data_teknis', $testing[5]->g->data_teknis ?? '');
        $templateProcessor->setValue('6_g_hasil_uji', $testing[5]->g->hasil_uji ?? '');
        $templateProcessor->setValue('6_g_ambang_batas', $testing[5]->g->ambang_batas ?? '');
        $templateProcessor->setValue('6_g_keterangan', $testing[5]->g->keterangan ?? '');

        $templateProcessor->setValue('7_a_data_teknis', $testing[6]->a->data_teknis ?? '');
        $templateProcessor->setValue('7_a_hasil_uji', $testing[6]->a->hasil_uji ?? '');
        $templateProcessor->setValue('7_a_ambang_batas', $testing[6]->a->ambang_batas ?? '');
        $templateProcessor->setValue('7_a_keterangan', $testing[6]->a->keterangan ?? '');
        $templateProcessor->setValue('7_b_data_teknis', $testing[6]->b->data_teknis ?? '');
        $templateProcessor->setValue('7_b_hasil_uji', $testing[6]->b->hasil_uji ?? '');
        $templateProcessor->setValue('7_b_ambang_batas', $testing[6]->b->ambang_batas ?? '');
        $templateProcessor->setValue('7_b_keterangan', $testing[6]->b->keterangan ?? '');
        $templateProcessor->setValue('7_c_data_teknis', $testing[6]->c->data_teknis ?? '');
        $templateProcessor->setValue('7_c_hasil_uji', $testing[6]->c->hasil_uji ?? '');
        $templateProcessor->setValue('7_c_ambang_batas', $testing[6]->c->ambang_batas ?? '');
        $templateProcessor->setValue('7_c_keterangan', $testing[6]->c->keterangan ?? '');
        $templateProcessor->setValue('7_d_data_teknis', $testing[6]->d->data_teknis ?? '');
        $templateProcessor->setValue('7_d_hasil_uji', $testing[6]->d->hasil_uji ?? '');
        $templateProcessor->setValue('7_d_ambang_batas', $testing[6]->d->ambang_batas ?? '');
        $templateProcessor->setValue('7_d_keterangan', $testing[6]->d->keterangan ?? '');
        $templateProcessor->setValue('7_e_data_teknis', $testing[6]->e->data_teknis ?? '');
        $templateProcessor->setValue('7_e_hasil_uji', $testing[6]->e->hasil_uji ?? '');
        $templateProcessor->setValue('7_e_ambang_batas', $testing[6]->e->ambang_batas ?? '');
        $templateProcessor->setValue('7_e_keterangan', $testing[6]->e->keterangan ?? '');
        $templateProcessor->setValue('7_f_data_teknis', $testing[6]->f->data_teknis ?? '');
        $templateProcessor->setValue('7_f_hasil_uji', $testing[6]->f->hasil_uji ?? '');
        $templateProcessor->setValue('7_f_ambang_batas', $testing[6]->f->ambang_batas ?? '');
        $templateProcessor->setValue('7_f_keterangan', $testing[6]->f->keterangan ?? '');
        $templateProcessor->setValue('7_g_data_teknis', $testing[6]->g->data_teknis ?? '');
        $templateProcessor->setValue('7_g_hasil_uji', $testing[6]->g->hasil_uji ?? '');
        $templateProcessor->setValue('7_g_ambang_batas', $testing[6]->g->ambang_batas ?? '');
        $templateProcessor->setValue('7_g_keterangan', $testing[6]->g->keterangan ?? '');

        $templateProcessor->setValue('7_h_data_teknis', $testing[6]->h->data_teknis ?? '');
        $templateProcessor->setValue('7_h_hasil_uji', $testing[6]->h->hasil_uji ?? '');
        $templateProcessor->setValue('7_h_ambang_batas', $testing[6]->h->ambang_batas ?? '');
        $templateProcessor->setValue('7_h_keterangan', $testing[6]->h->keterangan ?? '');
        $templateProcessor->setValue('7_i_data_teknis', $testing[6]->i->data_teknis ?? '');
        $templateProcessor->setValue('7_i_hasil_uji', $testing[6]->i->hasil_uji ?? '');
        $templateProcessor->setValue('7_i_ambang_batas', $testing[6]->i->ambang_batas ?? '');
        $templateProcessor->setValue('7_i_keterangan', $testing[6]->i->keterangan ?? '');
        $templateProcessor->setValue('7_j_data_teknis', $testing[6]->j->data_teknis ?? '');
        $templateProcessor->setValue('7_j_hasil_uji', $testing[6]->j->hasil_uji ?? '');
        $templateProcessor->setValue('7_j_ambang_batas', $testing[6]->j->ambang_batas ?? '');
        $templateProcessor->setValue('7_j_keterangan', $testing[6]->j->keterangan ?? '');
        $templateProcessor->setValue('7_k_data_teknis', $testing[6]->k->data_teknis ?? '');
        $templateProcessor->setValue('7_k_hasil_uji', $testing[6]->k->hasil_uji ?? '');
        $templateProcessor->setValue('7_k_ambang_batas', $testing[6]->k->ambang_batas ?? '');
        $templateProcessor->setValue('7_k_keterangan', $testing[6]->k->keterangan ?? '');
        $templateProcessor->setValue('7_l_data_teknis', $testing[6]->l->data_teknis ?? '');
        $templateProcessor->setValue('7_l_hasil_uji', $testing[6]->l->hasil_uji ?? '');
        $templateProcessor->setValue('7_l_ambang_batas', $testing[6]->l->ambang_batas ?? '');
        $templateProcessor->setValue('7_l_keterangan', $testing[6]->l->keterangan ?? '');
        $templateProcessor->setValue('date', CertificateHelper::formatDateID($testLetter->certificate->date_srut) ?? '');

        $outputPath = storage_path('app/public/certificate-sut/'."Sertifikat_SUT_".$test_letter_id.'.docx');

        if (File::exists($outputPath)) {
            File::delete($outputPath);
        }

        $templateProcessor->saveAs($outputPath);

        $result = [
            'download' => route('secure.file', ['path' => Helper::encrypt("certificate-sut/".Str::after($outputPath, 'certificate-sut/'))]),
            'file_name' => Str::after($outputPath, 'certificate-sut/')
        ];

        return $this->setResult($result)->setStatus(true)->setCode(200);
    }

    /**
     * @return mixed
     */
    public function send_draft($test_letter_id)
    {
        DB::beginTransaction();
        try {
            $result = $this->mainRepository->findByTestLetterId($test_letter_id);

            if ($result->test_letter->workshop_type == "A") {
                $certificate_sut = $this->generate_certificate_sut($test_letter_id)->getResult();
                $result->type_test_attachment = 'certificate-sut/'. $certificate_sut['file_name'];
            }

            if ($result->test_letter->workshop_type == "B") {
                $certificate_sut = $this->generate_certificate_sut($test_letter_id)->getResult();
                $certificate_srut = $this->generate_certificate_srut($test_letter_id)->getResult();
                $certificate_attachment = $this->generate_certificate_attachment($test_letter_id)->getResult();
                $sk = $this->generate_sk($test_letter_id)->getResult();
                $result->registration_attachment = 'certificate-srut/'. $certificate_srut['file_name'];
                $result->type_test_attachment = 'certificate-sut/'. $certificate_sut['file_name'];
                $result->certificate_attachment = 'certificate-attachment/'. $certificate_attachment['file_name'];
                $result->sk_attachment = 'sk-srut-sut/'. $sk['file_name'];
            }

            $result->status = 'Draft';
            $result->save();

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
     * @param $data
     * @return mixed
     */
    public function upsert_form_certificate($data)
    {
        DB::beginTransaction();
        try {
            $id = $data['id'];
            $testLetter = $this->testLetterRepository->find($data['test_letter_id']);
            $data['user_id'] = $testLetter->user_id;
            $data['date_sut'] = date('Y-m-d');
            $data['date_srut'] = date('Y-m-d');
            $data['date_sk'] = date('Y-m-d');
            $data['is_form_completed'] = 1;
            $data['status'] = 'Draft';
            $data['testing'] = json_encode(@$data['pengujian']) ?? null;
            unset($data['id']);

            if ($id == null) {
                $this->mainRepository->create($data);
            } else {
                $this->mainRepository->update($id, $data);
            }

            $redirect = redirect()->intended(URL::route('certificate.test.letter.generate', ['id' => Helper::encrypt($data['test_letter_id'])]));
            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()])
                ->setMessage("Data berhasil dibuat");
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
            ->addColumn('action', function ($row) {
                $verificationMenu = '';
                if (auth()->user()->isSuperAdmin() && $row->status == 'Draft') {
                    $verificationMenu = '<a class="dropdown-item detail" href="'.route('certificate.test.letter.verification.draft.form', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Verifikasi
                                </a>';
                }

                if (auth()->user()->isSuperAdmin()) {
                    $verificationMenu = '<a class="dropdown-item detail" href="'.route('certificate.test.letter.show', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Detail
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

    /**
     * @param $id
     * @return mixed
     */
    public function verify_draft($id)
    {
        DB::beginTransaction();
        try {

            $id = Helper::decrypt($id);
            $result = $this->mainRepository->find($id);
            $result->status = 'Terverifikasi';
            $result->save();

            $redirect = redirect()->intended(URL::route('certificate.test.letter.index'));

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

    public function upload_archive($data)
    {
        DB::beginTransaction();
        try {
            $certificate = $this->mainRepository->find($data['id']);

            if (@$data['sk_attachment']) {
                if (@$certificate->sk_attachment && str_contains($certificate->sk_attachment, 'sk-srut-sut')) {
                    if (file_exists(storage_path('app/public/'.@$certificate->sk_attachment))) {
                        unlink(storage_path('app/public/'.@$certificate->sk_attachment));
                    }
                }

                // file surat keterangan
                $fileSKAttachment = $data['sk_attachment'];
                $originalSKAttachment = $fileSKAttachment->getClientOriginalName();
                $extensionApplicationLetter = $fileSKAttachment->getClientOriginalExtension();
                $newFileSKAttachment = 'Surat_Keterangan_' . uniqid() . '.' . $extensionApplicationLetter;
                $filePathApplicationLetter = $fileSKAttachment->storeAs('sk-srut-sut', $originalSKAttachment, 'public');
                $data['sk_attachment'] = $filePathApplicationLetter;
            } else {
                $data['sk_attachment'] = @$data['old_sk_attachment'];
                unset($data['old_sk_attachment']);
            }

            if (@$data['type_test_attachment']) {
                if (@$certificate->type_test_attachment && str_contains($certificate->type_test_attachment, 'certificate-sut')) {
                    if (file_exists(storage_path('app/public/'.@$certificate->type_test_attachment))) {
                        unlink(storage_path('app/public/'.@$certificate->type_test_attachment));
                    }
                }

                // file sertifikat
                $fileTypeTest = $data['type_test_attachment'];
                $originalNameTypeTest = $fileTypeTest->getClientOriginalName();
                $extensionTypeTest = $fileTypeTest->getClientOriginalExtension();
                $newFileNameTypeTest = 'Sertifikat - ' . uniqid() . '.' . $extensionTypeTest;
                $filePathTypeTest = $fileTypeTest->storeAs('certificate-sut', $originalNameTypeTest, 'public');
                $data['type_test_attachment'] = $filePathTypeTest;
            } else {
                $data['type_test_attachment'] = @$data['old_type_test_attachment'];
                unset($data['old_type_test_attachment']);
            }

            if (@$data['registration_attachment']) {
                if (@$certificate->registration_attachment && str_contains($certificate->registration_attachment, 'certificate-srut')) {
                    if (file_exists(storage_path('app/public/'.@$certificate->registration_attachment))) {
                        unlink(storage_path('app/public/'.@$certificate->registration_attachment));
                    }
                }

                // file sertifikat
                $fileRegis = $data['registration_attachment'];
                $originalNameRegis = $fileRegis->getClientOriginalName();
                $extensionRegis = $fileRegis->getClientOriginalExtension();
                $newFileNameRegis = 'Sertifikat - ' . uniqid() . '.' . $extensionRegis;
                $filePathRegis = $fileRegis->storeAs('certificate-srut', $originalNameRegis, 'public');
                $data['registration_attachment'] = $filePathRegis;
            } else {
                $data['registration_attachment'] = @$data['old_registration_attachment'];
                unset($data['old_registration_attachment']);
            }

            if (@$data['certificate_attachment']) {
                if (@$certificate->certificate_attachment && str_contains($certificate->certificate_attachment, 'certificate-srut')) {
                    if (file_exists(storage_path('app/public/'.@$certificate->certificate_attachment))) {
                        unlink(storage_path('app/public/'.@$certificate->certificate_attachment));
                    }
                }

                // file sertifikat
                $fileCertificateAttachment = $data['certificate_attachment'];
                $originalNameCertificateAttachment = $fileCertificateAttachment->getClientOriginalName();
                $extensionCertificateAttachment = $fileCertificateAttachment->getClientOriginalExtension();
                $newFileNameCertificateAttachment = 'Lampiran - ' . uniqid() . '.' . $extensionCertificateAttachment;
                $filePathCertificateAttachment = $fileCertificateAttachment->storeAs('certificate-srut', $originalNameCertificateAttachment, 'public');
                $data['certificate_attachment'] = $filePathCertificateAttachment;
            } else {
                $data['certificate_attachment'] = @$data['old_certificate_attachment'];
                unset($data['old_certificate_attachment']);
            }

            if ($certificate->test_letter->workshop_type == "A") {
                $mail['title'] = 'Dokumen Uji Tipe Kendaraan Listrik Anda Telah Tersedia';
                $mail['message'] = '
                                    <h2>🔧 Dokumen Uji Tipe Telah Tersedia</h2>
                                    <p>
                                        Terima kasih atas partisipasi Anda dalam program percepatan kendaraan listrik di Indonesia.
                                        Kami informasikan bahwa dokumen *Surat Uji Tipe (SUT)* kendaraan listrik Anda telah tersedia dan dapat diunduh melalui tombol di bawah ini:
                                    </p>

                                    <a href="' . route('secure.file', ['path' => Helper::encrypt($certificate->type_test_attachment)]) . '" style="display: inline-block; padding: 12px 20px; margin: 10px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #17a2b8;">🔧 Download Surat Uji Tipe</a>

                                    <p style="margin-top: 20px;">
                                        Untuk melanjutkan proses dan memperoleh dokumen lanjutan seperti *Surat Registrasi Uji Tipe (SRUT)*, dan *Surat Keterangan* . Anda perlu terlebih dahulu mengajukan permohonan SRUT.
                                        Pengajuan ini dapat dilakukan melalui sistem kami, serta melampirkan dokumen tambahan yang dibutuhkan.
                                    </p>

                                    <p>
                                        Silakan hubungi tim kami jika Anda memerlukan panduan dalam mengajukan permohonan SRUT atau menyiapkan dokumen tambahan.
                                    </p>

                                    <p style="margin-top: 20px; font-size: 14px; color: #777;">
                                        🚀 Semoga proses administrasi kendaraan Anda berjalan lancar.<br><br>
                                        Salam hangat,<br>
                                        <strong>Tim Administrasi SwitchEv</strong>
                                    </p>
                                ';
            }

            if ($certificate->test_letter->workshop_type == "B") {
                $mail['title'] = 'Selamat! Dokumen Kendaraan Listrik Anda Telah Tersedia untuk Diunduh';
                $mail['message'] = '
                            <h2>⚡ Dokumen Kendaraan Listrik Telah Tersedia ⚡</h2>
                            <p>
                                Terima kasih atas partisipasi Anda dalam program percepatan kendaraan listrik di Indonesia.
                                Beberapa dokumen penting terkait kendaraan listrik Anda kini telah tersedia dan dapat diunduh melalui tombol di bawah ini:
                            </p>

                            <a href="' . route('secure.file', ['path' => Helper::encrypt($certificate->sk_attachment)]) . '" style="display: inline-block; padding: 12px 20px; margin: 10px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #007bff;">📄 Download Surat Keterangan</a>

                            <a href="' . route('secure.file', ['path' => Helper::encrypt($certificate->registration_attachment)]) . '" style="display: inline-block; padding: 12px 20px; margin: 10px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #28a745;">📜 Download Surat Registrasi Uji Tipe</a>

                            <a href="' . route('secure.file', ['path' => Helper::encrypt($certificate->type_test_attachment)]) . '" style="display: inline-block; padding: 12px 20px; margin: 10px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #17a2b8;">🔧 Download Surat Uji Tipe</a>

                            <a href="' . route('secure.file', ['path' => Helper::encrypt($certificate->certificate_attachment)]) . '" style="display: inline-block; padding: 12px 20px; margin: 10px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #4d17b8;">🔧 Download Lampiran</a>

                            <p style="margin-top: 20px; font-size: 14px; color: #777;">
                                🚀 Semoga dokumen ini membantu proses administrasi kendaraan Anda dengan lancar.
                                Jika ada pertanyaan, silakan hubungi tim kami melalui kontak yang tersedia.
                                <br><br>
                                Salam hangat,<br>
                                <strong>Tim Administrasi SwitchEv</strong>
                            </p>
                        ';
            }

            if (@$certificate) {
                $certificate->type_test_attachment = $data['type_test_attachment'];
                $certificate->registration_attachment = $data['registration_attachment'];
                $certificate->sk_attachment = $data['sk_attachment'];
                $certificate->certificate_attachment = $data['certificate_attachment'];
                $certificate->status = 'Selesai';
                $certificate->save();
                $this->testLetterRepository->update($certificate->test_letter_id, [
                    'step' => 'completed',
                    'message' => '<p>
                                Terima kasih atas partisipasi Anda dalam program percepatan kendaraan listrik di Indonesia.
                                Beberapa dokumen penting terkait kendaraan listrik Anda kini telah tersedia dan dapat diunduh melalui tombol di bawah ini:
                            </p>'
                ]);
            }

            Mail::to($certificate->user->email)->send(new MailSend($mail));

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => route('test.letter.index')])
                ->setMessage("Unggah berkas berhasil dilakukan");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @param $test_letter_id
     * @return mixed
     */
    public function generate_certificate_attachment($test_letter_id)
    {
        $testLetter = $this->testLetterRepository->find($test_letter_id);
        $testing = json_decode($testLetter->certificate->testing);
        $templatePath =  storage_path('app/templates/LAMPIRAN .docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('rem_belakang', $testing[0]->a->hasil_uji->belakang ?? '');
        $templateProcessor->setValue('rem_depan', $testing[0]->a->hasil_uji->depan ?? '');
        $templateProcessor->setValue('rem_a_ambang_batas', $testing[0]->a->ambang_batas ?? '');
        $templateProcessor->setValue('nomor_surat', Helper::generateNomorSurat($testLetter->queue_number, "SUT"));
        $templateProcessor->setValue('rem_a_keterangan', $testing[0]->a->keterangan ?? '');
        $templateProcessor->setValue('lampu_a_hasil_uji', $testing[1]->a->hasil_uji ?? '');
        $templateProcessor->setValue('lampu_b_hasil_uji', $testing[1]->b->hasil_uji ?? '');
        $templateProcessor->setValue('lampu_a_ambang_batas', $testing[1]->a->ambang_batas ?? '');
        $templateProcessor->setValue('lampu_a_keterangan', $testing[1]->a->keterangan ?? '');
        $templateProcessor->setValue('lampu_b_keterangan', $testing[1]->b->keterangan ?? '');
        $templateProcessor->setValue('lampu_b_penyimpangan_kanan', $testing[1]->b->peyimpangan_kanan ?? '');
        $templateProcessor->setValue('lampu_b_penyimpangan_kiri', $testing[1]->b->peyimpangan_kiri ?? '');
        $templateProcessor->setValue('klakson_hasil_uji', $testing[2]->a->hasil_uji ?? '');
        $templateProcessor->setValue('klakson_ambang_batas', $testing[2]->a->ambang_batas ?? '');
        $templateProcessor->setValue('klakson_keterangan', $testing[2]->a->keterangan ?? '');
        $templateProcessor->setValue('berat_data_teknis', $testing[3]->a->data_teknis ?? '');
        $templateProcessor->setValue('berat_hasil_uji', $testing[3]->a->hasil_uji ?? '');
        $templateProcessor->setValue('berat_ambang_batas', $testing[3]->a->ambang_batas ?? '');
        $templateProcessor->setValue('berat_keterangan', $testing[3]->a->keterangan ?? '');
        $templateProcessor->setValue('speedometer_data_teknis', $testing[4]->a->data_teknis ?? '');
        $templateProcessor->setValue('speedometer_hasil_uji', $testing[4]->a->hasil_uji ?? '');
        $templateProcessor->setValue('speedometer_ambang_batas', $testing[4]->a->ambang_batas ?? '');
        $templateProcessor->setValue('speedometer_keterangan', $testing[4]->a->keterangan ?? '');

        $templateProcessor->setValue('6_a_data_teknis', $testing[5]->a->data_teknis ?? '');
        $templateProcessor->setValue('6_a_hasil_uji', $testing[5]->a->hasil_uji ?? '');
        $templateProcessor->setValue('6_a_ambang_batas', $testing[5]->a->ambang_batas ?? '');
        $templateProcessor->setValue('6_a_keterangan', $testing[5]->a->keterangan ?? '');
        $templateProcessor->setValue('6_b_data_teknis', $testing[5]->b->data_teknis ?? '');
        $templateProcessor->setValue('6_b_hasil_uji', $testing[5]->b->hasil_uji ?? '');
        $templateProcessor->setValue('6_b_ambang_batas', $testing[5]->b->ambang_batas ?? '');
        $templateProcessor->setValue('6_b_keterangan', $testing[5]->b->keterangan ?? '');
        $templateProcessor->setValue('6_c_data_teknis', $testing[5]->c->data_teknis ?? '');
        $templateProcessor->setValue('6_c_hasil_uji', $testing[5]->c->hasil_uji ?? '');
        $templateProcessor->setValue('6_c_ambang_batas', $testing[5]->c->ambang_batas ?? '');
        $templateProcessor->setValue('6_c_keterangan', $testing[5]->c->keterangan ?? '');
        $templateProcessor->setValue('6_d_data_teknis', $testing[5]->d->data_teknis ?? '');
        $templateProcessor->setValue('6_d_hasil_uji', $testing[5]->d->hasil_uji ?? '');
        $templateProcessor->setValue('6_d_ambang_batas', $testing[5]->d->ambang_batas ?? '');
        $templateProcessor->setValue('6_d_keterangan', $testing[5]->d->keterangan ?? '');
        $templateProcessor->setValue('6_e_data_teknis', $testing[5]->e->data_teknis ?? '');
        $templateProcessor->setValue('6_e_hasil_uji', $testing[5]->e->hasil_uji ?? '');
        $templateProcessor->setValue('6_e_ambang_batas', $testing[5]->e->ambang_batas ?? '');
        $templateProcessor->setValue('6_e_keterangan', $testing[5]->e->keterangan ?? '');
        $templateProcessor->setValue('6_f_data_teknis', $testing[5]->f->data_teknis ?? '');
        $templateProcessor->setValue('6_f_hasil_uji', $testing[5]->f->hasil_uji ?? '');
        $templateProcessor->setValue('6_f_ambang_batas', $testing[5]->f->ambang_batas ?? '');
        $templateProcessor->setValue('6_f_keterangan', $testing[5]->f->keterangan ?? '');
        $templateProcessor->setValue('6_g_data_teknis', $testing[5]->g->data_teknis ?? '');
        $templateProcessor->setValue('6_g_hasil_uji', $testing[5]->g->hasil_uji ?? '');
        $templateProcessor->setValue('6_g_ambang_batas', $testing[5]->g->ambang_batas ?? '');
        $templateProcessor->setValue('6_g_keterangan', $testing[5]->g->keterangan ?? '');

        $templateProcessor->setValue('7_a_data_teknis', $testing[6]->a->data_teknis ?? '');
        $templateProcessor->setValue('7_a_hasil_uji', $testing[6]->a->hasil_uji ?? '');
        $templateProcessor->setValue('7_a_ambang_batas', $testing[6]->a->ambang_batas ?? '');
        $templateProcessor->setValue('7_a_keterangan', $testing[6]->a->keterangan ?? '');
        $templateProcessor->setValue('7_b_data_teknis', $testing[6]->b->data_teknis ?? '');
        $templateProcessor->setValue('7_b_hasil_uji', $testing[6]->b->hasil_uji ?? '');
        $templateProcessor->setValue('7_b_ambang_batas', $testing[6]->b->ambang_batas ?? '');
        $templateProcessor->setValue('7_b_keterangan', $testing[6]->b->keterangan ?? '');
        $templateProcessor->setValue('7_c_data_teknis', $testing[6]->c->data_teknis ?? '');
        $templateProcessor->setValue('7_c_hasil_uji', $testing[6]->c->hasil_uji ?? '');
        $templateProcessor->setValue('7_c_ambang_batas', $testing[6]->c->ambang_batas ?? '');
        $templateProcessor->setValue('7_c_keterangan', $testing[6]->c->keterangan ?? '');
        $templateProcessor->setValue('7_d_data_teknis', $testing[6]->d->data_teknis ?? '');
        $templateProcessor->setValue('7_d_hasil_uji', $testing[6]->d->hasil_uji ?? '');
        $templateProcessor->setValue('7_d_ambang_batas', $testing[6]->d->ambang_batas ?? '');
        $templateProcessor->setValue('7_d_keterangan', $testing[6]->d->keterangan ?? '');
        $templateProcessor->setValue('7_e_data_teknis', $testing[6]->e->data_teknis ?? '');
        $templateProcessor->setValue('7_e_hasil_uji', $testing[6]->e->hasil_uji ?? '');
        $templateProcessor->setValue('7_e_ambang_batas', $testing[6]->e->ambang_batas ?? '');
        $templateProcessor->setValue('7_e_keterangan', $testing[6]->e->keterangan ?? '');
        $templateProcessor->setValue('7_f_data_teknis', $testing[6]->f->data_teknis ?? '');
        $templateProcessor->setValue('7_f_hasil_uji', $testing[6]->f->hasil_uji ?? '');
        $templateProcessor->setValue('7_f_ambang_batas', $testing[6]->f->ambang_batas ?? '');
        $templateProcessor->setValue('7_f_keterangan', $testing[6]->f->keterangan ?? '');
        $templateProcessor->setValue('7_g_data_teknis', $testing[6]->g->data_teknis ?? '');
        $templateProcessor->setValue('7_g_hasil_uji', $testing[6]->g->hasil_uji ?? '');
        $templateProcessor->setValue('7_g_ambang_batas', $testing[6]->g->ambang_batas ?? '');
        $templateProcessor->setValue('7_g_keterangan', $testing[6]->g->keterangan ?? '');

        $templateProcessor->setValue('7_h_data_teknis', $testing[6]->h->data_teknis ?? '');
        $templateProcessor->setValue('7_h_hasil_uji', $testing[6]->h->hasil_uji ?? '');
        $templateProcessor->setValue('7_h_ambang_batas', $testing[6]->h->ambang_batas ?? '');
        $templateProcessor->setValue('7_h_keterangan', $testing[6]->h->keterangan ?? '');
        $templateProcessor->setValue('7_i_data_teknis', $testing[6]->i->data_teknis ?? '');
        $templateProcessor->setValue('7_i_hasil_uji', $testing[6]->i->hasil_uji ?? '');
        $templateProcessor->setValue('7_i_ambang_batas', $testing[6]->i->ambang_batas ?? '');
        $templateProcessor->setValue('7_i_keterangan', $testing[6]->i->keterangan ?? '');
        $templateProcessor->setValue('7_j_data_teknis', $testing[6]->j->data_teknis ?? '');
        $templateProcessor->setValue('7_j_hasil_uji', $testing[6]->j->hasil_uji ?? '');
        $templateProcessor->setValue('7_j_ambang_batas', $testing[6]->j->ambang_batas ?? '');
        $templateProcessor->setValue('7_j_keterangan', $testing[6]->j->keterangan ?? '');
        $templateProcessor->setValue('7_k_data_teknis', $testing[6]->k->data_teknis ?? '');
        $templateProcessor->setValue('7_k_hasil_uji', $testing[6]->k->hasil_uji ?? '');
        $templateProcessor->setValue('7_k_ambang_batas', $testing[6]->k->ambang_batas ?? '');
        $templateProcessor->setValue('7_k_keterangan', $testing[6]->k->keterangan ?? '');
        $templateProcessor->setValue('7_l_data_teknis', $testing[6]->l->data_teknis ?? '');
        $templateProcessor->setValue('7_l_hasil_uji', $testing[6]->l->hasil_uji ?? '');
        $templateProcessor->setValue('7_l_ambang_batas', $testing[6]->l->ambang_batas ?? '');
        $templateProcessor->setValue('7_l_keterangan', $testing[6]->l->keterangan ?? '');
        $templateProcessor->setValue('date', CertificateHelper::formatDateID($testLetter->certificate->date_srut) ?? '');

        $outputPath = storage_path('app/public/certificate-attachment/'."Lampiran_".$test_letter_id.'.docx');
        $relativePath = Str::after($outputPath, 'certificate-attachment/');
        $pdfRelativePath = Str::replaceLast('.docx', '.pdf', $relativePath);

        if (File::exists($outputPath)) {
            File::delete($outputPath);
        }

        $templateProcessor->saveAs($outputPath);

        $result = [
            'download' => route('secure.file', ['path' => Helper::encrypt("certificate-attachment/".Str::after($outputPath, 'certificate-attachment/'))]),
            'file_name' => Str::after($outputPath, 'certificate-attachment/')
        ];

        return $this->setResult($result)->setStatus(true)->setCode(200);
    }
}
