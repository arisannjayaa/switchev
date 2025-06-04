<?php

namespace App\Services\Conversion;

use App\Helpers\Helper;
use App\Mail\MailSend;
use App\Mail\VerificationZoom;
use App\Models\Equipment;
use App\Repositories\Certificate\CertificateRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Conversion\ConversionRepository;
use Yajra\DataTables\Facades\DataTables;

class ConversionServiceImplement extends ServiceApi implements ConversionService{

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
     protected $mainRepository, $certificateRepository;

    public function __construct(ConversionRepository $mainRepository, CertificateRepository $certificateRepository)
    {
      $this->mainRepository = $mainRepository;
      $this->certificateRepository = $certificateRepository;
    }

    // Define your custom methods :)
    public function checkStatusUser()
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            return $this->checkConversion();
        }

        if (auth()->user()->isGuest() && auth()->user()->isPending()) {
            return view('apps.conversion.pending');
        }

        if (auth()->user()->isAdmin()) {
            return view('apps.conversion.index');
        }
    }

    public function upsert($data)
    {
        DB::beginTransaction();
        try {
            $data['user_id'] = auth()->user()->id;
            $data['step'] = 1;
            $data['status'] = "checking";
            $data['message'] = "Tim kami saat ini sedang memeriksa dan memverifikasi berkas yang telah Anda unggah untuk memastikan kelengkapannya. Proses ini mungkin membutuhkan waktu, dan kami akan memberi kabar lebih lanjut setelah verifikasi selesai.";

            // file application letter
            $fileApplicationLetter = $data['application_letter'];
            $originalNameApplicationLetter = $fileApplicationLetter->getClientOriginalName();
            $extensionApplicationLetter = $fileApplicationLetter->getClientOriginalExtension();
            $newFileNameApplicationLetter = 'Surat Permohonan_' . uniqid() . '.' . $extensionApplicationLetter;
            $filePathApplicationLetter = $fileApplicationLetter->storeAs('documents', $newFileNameApplicationLetter, 'public');
            $data['application_letter'] = $filePathApplicationLetter;

            // file technician_competency
            $fileTechnicianCompetency = $data['technician_competency'];
            $originalNameTechnicianCompetency = $fileTechnicianCompetency->getClientOriginalName();
            $extensionTechnicianCompetency = $fileTechnicianCompetency->getClientOriginalExtension();
            $newFileNameTechnicianCompetency = 'Lampiran Data SDM dan Sertifikat Kompetensi Teknisi_' . uniqid() . '.' . $extensionTechnicianCompetency;
            $filePathTechnicianCompetency = $fileTechnicianCompetency->storeAs('documents', $newFileNameTechnicianCompetency, 'public');
            $data['technician_competency'] = $filePathTechnicianCompetency;

            // file equipment
            $fileEquipment = $data['equipment'];
            $originalNameEquipment = $fileEquipment->getClientOriginalName();
            $extensionEquipment = $fileEquipment->getClientOriginalExtension();
            $newFileNameEquipment = 'Lampiran Data Peralatan_' . uniqid() . '.' . $extensionEquipment;
            $filePathEquipment = $fileEquipment->storeAs('documents', $newFileNameEquipment, 'public');
            $data['equipment'] = $filePathEquipment;

            // file sop
            $fileSop = $data['sop'];
            $originalNameSop = $fileSop->getClientOriginalName();
            $extensionSop = $fileSop->getClientOriginalExtension();
            $newFileNameSop = 'Lampiran Data SOP_' . uniqid() . '.' . $extensionSop;
            $filePathSop = $fileSop->storeAs('documents', $newFileNameSop, 'public');
            $data['sop'] = $filePathSop;

            // file wiring_diagram
            $fileWiringDiagram = $data['wiring_diagram'];
            $originalNameWiringDiagram = $fileWiringDiagram->getClientOriginalName();
            $extensionWiringDiagram = $fileWiringDiagram->getClientOriginalExtension();
            $newFileNameWiringDiagram = 'Lampiran Data Wiring Diagram_' . uniqid() . '.' . $extensionWiringDiagram;
            $filePathWiringDiagram = $fileWiringDiagram->storeAs('documents', $newFileNameWiringDiagram, 'public');
            $data['wiring_diagram'] = $filePathWiringDiagram;

            if (@$data['id']) {
                $this->mainRepository->update($data['id'], $data);
            }

            if (!@$data['id']) {
                unset($data['id']);
                $lastQueue = $this->mainRepository->getLastQueue();
                $lastNumber = $lastQueue ? (int) $lastQueue->queue_number : 0;
                $newQueueNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                $data['queue_number'] = $newQueueNumber;
                $data['sk_code'] = Helper::generateNomorSurat($newQueueNumber, "SK/BK");
                $data['certificate_code'] = Helper::generateNomorSurat($newQueueNumber, "SBK");
                $this->mainRepository->create($data);
            }

            $redirect = redirect()->intended(URL::route('conversion.index'));
            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()])
                ->setMessage("Berhasil melakukan pendaftaran");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function checkConversion()
    {
        if ($this->mainRepository->checkIsConversion()) {
            return view('apps.conversion.guest-index');
        }

        return view('apps.conversion.guest-welcome');
    }

    public function table()
    {
        return DataTables::of($this->mainRepository->table())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $evaluationMenu = '';
                $verificationMenu = '';
                $menuGuest = '';
                $menuAdmin = '';
                if (auth()->user()->isAdmin()) {
                    $verificationMenu = '<a class="dropdown-item detail" href="'.route('conversion.show', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                      Lihat
                                    </a>';

                    if ($row->status != 'is_being_uploaded') {
                        $verificationMenu .= '<a class="dropdown-item verification-zoom" href="'.route('conversion.verification', ['id' => Helper::encrypt( $row->id)]).'" data-id="'.$row->id.'">
                                      Verifikasi
                                    </a>';
                    }

                    if (!@$row->certificate && $row->step == 5) {
                        $evaluationMenu = '<a class="dropdown-item detail" href="'.route('certificate.certificate.form', ['conversion_id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                          Penilaian
                                        </a>';
                    }
                }

                if (auth()->user()->isGuest()) {
                    $menuGuest = '<a class="dropdown-item detail" href="'.route('conversion.process.detail', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                          Proses Status
                                        </a>';
                }

                $html = '<span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-circle-horizontal"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M8 12l0 .01" /><path d="M12 12l0 .01" /><path d="M16 12l0 .01" /></svg></button>
                              <div class="dropdown-menu dropdown-menu-end" style="">
                              '.$verificationMenu.'
                              '.$evaluationMenu.'
                              '.$menuGuest.'
                              '.$menuAdmin.'
                              </div>
                            </span>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $conversion = $this->mainRepository->find($id);

            if ($conversion->step == 1) {
                $data['step'] = 2;
                $data['status'] = 'verified_upload';
                $data['message'] = 'Verifikasi berkas Anda oleh admin telah berhasil! Berkas yang Anda kirimkan telah disetujui dan sesuai dengan persyaratan yang ditentukan. Anda sekarang dapat melanjutkan ke tahap verifikasi berikutnya, yaitu verifikasi melalui Zoom.';
                $data['result'] = 'Berhasil memverifikasi berkas';
            }

            if ($conversion->step == 2) {
                $data['step'] = 3;
                $data['status'] = 'verified_zoom';
                $data['message'] = 'Terima kasih! Verifikasi melalui Zoom telah berhasil dilakukan. Kami mengonfirmasi bahwa semua informasi dan langkah-langkah yang diperlukan telah dipenuhi. Anda sekarang dapat melanjutkan ke tahap terakhir dari verifikasi, yaitu verifikasi lapangan.';
                $data['result'] = 'Berhasil memverifikasi via zoom';
            }

            if ($conversion->step == 3) {
                $data['step'] = 4;
                $data['status'] = 'verified_field';
                $data['message'] = 'Selamat! Verifikasi lapangan Anda berhasil diselesaikan. Dengan ini, seluruh proses verifikasi telah selesai dengan sukses. Anda sekarang dapat melanjutkan ke tahap selanjutnya atau menerima hasil dari verifikasi ini.';
                $data['result'] = 'Berhasil memverifikasi lapangan';
            }

            if ($conversion->step == 4) {
                $data['step'] = 5;
                $data['status'] = 'finished';
                $data['message'] = 'Semua data terverifikasi. Tunggu Admin untuk membuat Surat Keterangan dan Sertifikat';
                $data['result'] = 'Berhasil melakukan verifikasi semua data';
            }

            $this->mainRepository->update($id, $data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult([
                    'redirect' => route('conversion.index'),])
                ->setMessage($data['result']);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function reject($data)
    {
        DB::beginTransaction();
        try {
            $conversion = $this->mainRepository->find($data['id']);
            $data['step'] = 0;
            $data['status'] = 'rejected';

            if (file_exists(storage_path('app/public/'. $conversion->application_letter))) {
                unlink(storage_path('app/public/'. $conversion->application_letter));
            }

            if (file_exists(storage_path('app/public/'. $conversion->technician_competency))) {
                unlink(storage_path('app/public/' . $conversion->technician_competency));
            }

            if (file_exists(storage_path('app/public/'. $conversion->equipment))) {
                unlink(storage_path('app/public/' . $conversion->equipment));
            }

            if (file_exists(storage_path('app/public/'. $conversion->sop))) {
                unlink(storage_path('app/public/' . $conversion->sop));
            }

            if ($conversion->wiring_diagram != null) {
                if (file_exists(storage_path('app/public/'. $conversion->wiring_diagram))) {
                    unlink(storage_path('app/public/' . $conversion->wiring_diagram));
                }
            }

            $data['application_letter'] = null;
            $data['equipment'] = null;
            $data['technician_competency'] = null;
            $data['sop'] = null;
            $data['wiring_diagram']= null;
            $data['step_1_completed']= 0;
            $data['step_2_completed']= 0;
            $data['step_3_completed']= 0;
            $data['step_4_completed']= 0;

            $this->mainRepository->update($data['id'], $data);
            $data['title'] = 'Permohonan Sertifikasi di Tolak';
            $this->sendEmail($data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult([
                    'redirect' => route('conversion.index'),])
                ->setMessage("Data berhasil ditolak karena tidak sesuai");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function sendEmail($data)
    {
        DB::beginTransaction();
        try {
            $conversion = $this->mainRepository->find($data['id']);
            $mail['message'] = $data['message'];
            $mail['title'] = $data['title'];
            $mail['email'] = $conversion->user->email;

            unset($data['id']);

            if ($conversion->step == 2) {
                $data['zoom_mail_attempt'] = $conversion->zoom_mail_attempt + 1;
                $this->mainRepository->update($conversion->id, $data);
            }

            if ($conversion->step == 3) {
                $data['field_mail_attempt'] = $conversion->field_mail_attempt + 1;
                $this->mainRepository->update($conversion->id, $data);
            }

            Mail::to($mail['email'])->send(new MailSend($mail));

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("Berhasil mengirimkan notifikasi melalui email");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function findByUserId($user_id, $id)
    {
        try {
            $result = $this->mainRepository->findByUserId($user_id, $id);

            return $this->setStatus(true)
                ->setCode(200)
                ->setResult($result);
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function upsertFormResponsibleWorkshop($data)
    {
        DB::beginTransaction();
        try {
            $data['user_id'] = auth()->user()->id;
            $step = $data['step'];
            $data['step'] = 0;
            $data['message'] = '';
            $data['status'] = 'is_being_uploaded';

            if (@$data['id']) {
                $result = $this->mainRepository->find($data['id']);
                $result->step = $data['step'];
                $result->message = '';
                $result->status = 'is_being_uploaded';
                $result->type = $data['type'];
                $result->workshop = $data['workshop'];
                $result->address = $data['address'];
                $result->person_responsible = $data['person_responsible'];
                $result->whatapp_responsible = $data['whatapp_responsible'];
                $result->step_1_completed = $data['step_1_completed'];
                $result->save();
            }

            if (!@$data['id']) {
                $lastQueue = $this->mainRepository->getLastQueue();
                $lastNumber = $lastQueue ? (int) $lastQueue->queue_number : 0;
                $newQueueNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                $data['queue_number'] = $newQueueNumber;
                $data['sk_code'] = Helper::generateNomorSurat($newQueueNumber, "SK/BK");
                $data['certificate_code'] = Helper::generateNomorSurat($newQueueNumber, "SBK");
                $result = $this->mainRepository->create($data);
            }


            $redirect = redirect()->intended(URL::route('conversion.form', ['step' => $step + 1, 'id' => Helper::encrypt($result->id)]));

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function hasCompletedPreviousStep($user, $step, $conversionId)
    {
        $conversion = $this->mainRepository->findByUserId($user, $conversionId);

        if ($step == 1) {
            return @$conversion->step_1_completed != 0;
        }

        if ($step == 2) {
            return @$conversion->step_2_completed != 0;
        }

        if ($step == 3) {
            return @$conversion->step_3_completed != 0;
        }

        if ($step == 4) {
            return @$conversion->step_4_completed != 0;
        }

        return false;
    }

    public function upsertFormDocumentRequest($data)
    {
        DB::beginTransaction();
        try {
            $step = $data['step'];
            $conversion = $this->mainRepository->find($data['id']);

            if (!@$data['old_application_letter']) {
                if ($conversion->application_letter) {
                    if (file_exists(storage_path('app/public/'.$conversion->application_letter))) {
                        unlink(storage_path('app/public/'.$conversion->application_letter));
                    }
                }
                // file application letter
                $fileApplicationLetter = $data['application_letter'];
                $originalNameApplicationLetter = $fileApplicationLetter->getClientOriginalName();
                $extensionApplicationLetter = $fileApplicationLetter->getClientOriginalExtension();
                $newFileNameApplicationLetter = 'Surat Permohonan_' . uniqid() . '.' . $extensionApplicationLetter;
                $filePathApplicationLetter = $fileApplicationLetter->storeAs('documents', $newFileNameApplicationLetter, 'public');
                $data['application_letter'] = $filePathApplicationLetter;
            } else {
                $data['application_letter'] = $data['old_application_letter'];
                unset($data['old_application_letter']);
            }

            if (!@$data['old_technician_competency']) {
                if ($conversion->technician_competency) {
                    if (file_exists(storage_path('app/public/'.$conversion->technician_competency))) {
                        unlink(storage_path('app/public/'.$conversion->technician_competency));
                    }
                }
                // file technician_competency
                $fileTechnicianCompetency = $data['technician_competency'];
                $originalNameTechnicianCompetency = $fileTechnicianCompetency->getClientOriginalName();
                $extensionTechnicianCompetency = $fileTechnicianCompetency->getClientOriginalExtension();
                $newFileNameTechnicianCompetency = 'Lampiran Data SDM dan Sertifikat Kompetensi Teknisi_' . uniqid() . '.' . $extensionTechnicianCompetency;
                $filePathTechnicianCompetency = $fileTechnicianCompetency->storeAs('documents', $newFileNameTechnicianCompetency, 'public');
                $data['technician_competency'] = $filePathTechnicianCompetency;
            } else {
                $data['technician_competency'] = $data['old_technician_competency'];
                unset($data['old_technician_competency']);
            }

            if (!@$data['old_equipment']) {
                if ($conversion->equipment) {
                    if (file_exists(storage_path('app/public/'.$conversion->equipment))) {
                        unlink(storage_path('app/public/'.$conversion->equipment));
                    }
                }
                // file equipment
                $fileEquipment = $data['equipment'];
                $originalNameEquipment = $fileEquipment->getClientOriginalName();
                $extensionEquipment = $fileEquipment->getClientOriginalExtension();
                $newFileNameEquipment = 'Lampiran Data Peralatan_' . uniqid() . '.' . $extensionEquipment;
                $filePathEquipment = $fileEquipment->storeAs('documents', $newFileNameEquipment, 'public');
                $data['equipment'] = $filePathEquipment;
            } else {
                $data['equipment'] = $data['old_equipment'];
                unset($data['old_equipment']);
            }

            if (!@$data['old_sop']) {
                if ($conversion->sop) {
                    if (file_exists(storage_path('app/public/'.$conversion->sop))) {
                        unlink(storage_path('app/public/'.$conversion->sop));
                    }
                }
                // file sop
                $fileSop = $data['sop'];
                $originalNameSop = $fileSop->getClientOriginalName();
                $extensionSop = $fileSop->getClientOriginalExtension();
                $newFileNameSop = 'Lampiran Data SOP_' . uniqid() . '.' . $extensionSop;
                $filePathSop = $fileSop->storeAs('documents', $newFileNameSop, 'public');
                $data['sop'] = $filePathSop;
            } else {
                $data['sop'] = $data['old_sop'];
                unset($data['old_sop']);
            }


            if (!@$data['old_wiring_diagram'] && $conversion->type == "Selain Sepeda Motor") {
                if ($conversion->wiring_diagram) {
                    if (file_exists(storage_path('app/public/'.$conversion->wiring_diagram))) {
                        unlink(storage_path('app/public/'.$conversion->wiring_diagram));
                    }
                }
                // file wiring_diagram
                $fileWiringDiagram = $data['wiring_diagram'];
                $originalNameWiringDiagram = $fileWiringDiagram->getClientOriginalName();
                $extensionWiringDiagram = $fileWiringDiagram->getClientOriginalExtension();
                $newFileNameWiringDiagram = 'Lampiran Data Wiring Diagram_' . uniqid() . '.' . $extensionWiringDiagram;
                $filePathWiringDiagram = $fileWiringDiagram->storeAs('documents', $newFileNameWiringDiagram, 'public');
                $data['wiring_diagram'] = $filePathWiringDiagram;
            }

            if (@$data['old_wiring_diagram'] && $conversion->type == "Sepeda Motor") {
                $data['wiring_diagram'] = $data['old_wiring_diagram'];
                unset($data['old_wiring_diagram']);
            }

            if (@$data['id']) {
                $this->mainRepository->update($data['id'], $data);
            }

            if (!@$data['id']) {
                $this->mainRepository->create($data);
            }

            $redirect = redirect()->intended(URL::route('conversion.form', ['step' => $step + 1, 'id' => Helper::encrypt($data['id'])]));

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function isFormCompleted($userId)
    {
        $conversion = $this->mainRepository->findByUserId($userId);

        if (@$conversion->step_4_completed) {
            return true;
        }

        return false;
    }

    public function checklist($data)
    {
        try {
            foreach ($data['status'] as $id => $status) {
                Equipment::where('id', $id)->update(['status' => $status]);
            }

            return $this->approve($data['id']);
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
