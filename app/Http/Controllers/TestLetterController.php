<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\FormGenerateSpuRequest;
use App\Http\Requests\FormHaveSUT;
use App\Http\Requests\FormPermohonanSRUTRequest;
use App\Http\Requests\FormSendSpuRequest;
use App\Http\Requests\FormTestLetterCertificateRequest;
use App\Http\Requests\FormTestLetterRequest;
use App\Http\Requests\UploadPhysicalTestRequest;
use App\Services\TestLetter\TestLetterService;
use Illuminate\Http\Request;

class TestLetterController extends Controller
{
    protected $testLetterService;
    public function __construct(TestLetterService $testLetterService)
    {
        $this->testLetterService = $testLetterService;
    }

    /**
     * halaman data sut dan srut
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function index(Request $request)
    {
        if (auth()->user()->isBpljskb()) {
            return abort(403);
        }

        $data['test_letters'] = $this->testLetterService->findAllByUserId()->getResult();
        return view('apps.test-letter.index', $data);
    }

    /**
     * halaman form sut dan srut
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function form(Request $request, $id = null)
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            $data['test_letter'] = @$this->testLetterService->find(Helper::decrypt($id))->getResult();
            return view('apps.test-letter.form', $data);
        }

        return abort(403);
    }

    /**
     * halaman generate spu
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function generate_spu($id)
    {
        if (auth()->user()->isAdmin()) {
            $data['test_letter'] = @$this->testLetterService->findOrFail(Helper::decrypt($id))->getResult();
            return view('apps.test-letter.generate-spu', $data);
        }

        return abort(403);
    }

    /**
     * proses generate spu
     * @param FormGenerateSpuRequest $request
     * @return never
     */
    public function generate_spu_submit(FormGenerateSpuRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            $data = $request->only([
                'id',
                'workshop',
                'vehicle_name',
                'brand_type',
                'type',
                'vin_nik',
                'vehicle_code',
                'fuel',
                'name_uji_rem',
                'amount_uji_rem',
                'vol_uji_rem',
                'total_uji_rem',
                'name_uji_lampu_utama',
                'amount_uji_lampu_utama',
                'vol_uji_lampu_utama',
                'total_uji_lampu_utama',
                'name_uji_radius_putar',
                'amount_uji_radius_putar',
                'vol_uji_radius_putar',
                'total_uji_radius_putar',
                'name_uji_klakson',
                'amount_uji_klakson',
                'vol_uji_klakson',
                'total_uji_klakson',
                'name_uji_side_slip',
                'amount_uji_side_slip',
                'vol_uji_side_slip',
                'total_uji_side_slip',
                'name_uji_berat',
                'amount_uji_berat',
                'vol_uji_berat',
                'total_uji_berat',
                'name_uji_dimensi',
                'amount_uji_dimensi',
                'vol_uji_dimensi',
                'total_uji_dimensi',
                'name_uji_speedometer',
                'amount_uji_speedometer',
                'vol_uji_speedometer',
                'total_uji_speedometer',
                'name_uji_kontruksi',
                'amount_uji_kontruksi',
                'vol_uji_kontruksi',
                'total_uji_kontruksi',
                'name_uji_kebisingan',
                'amount_uji_kebisingan',
                'vol_uji_kebisingan',
                'total_uji_kebisingan',
            ]);
            return $this->testLetterService->generate_spu($data)->toJson();
        }

        return abort(403);
    }

    /**
     * halaman kirim spu
     * @param FormSendSpuRequest $request
     * @return never
     */
    public function send_spu(FormSendSpuRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            $data = $request->only([
                'id',
                'spu_attachment'
            ]);
            return $this->testLetterService->send_spu($data)->toJson();
        }

        return abort(403);
    }

    /**
     * proses insert atau update data sut srut
     * @param FormTestLetterRequest $request
     * @return never
     */
    public function upsert_form(FormTestLetterRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['workshop_type',
            'sop_component_installation',
            'technical_drawing',
            'conversion_workshop_certificate',
            'electrical_diagram',
            'photocopy_stnk',
            'physical_inspection',
            'test_report',
            'id',
            'responsible_person',
            'telephone',
            'address',
            'workshop','form_step',
            'conversion_type_test_application_letter'
        ]);
        return $this->testLetterService->upsert_form($data)->toJson();
    }

    /**
     * fetch data table sut srut
     * @return never
     */
    public function table()
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->testLetterService->table();
    }

    /**
     * menampilkan detail sut srut
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($request->id))->getResult();
        return view('apps.test-letter.detail', $data);
    }

    /**
     * menampilkan detail sut srut khusus role guest
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show_guest(Request $request)
    {
        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($request->id))->getResult();
        return view('apps.test-letter.detail-guest', $data);
    }

    /**
     * verifikasi permintaan terkait sut srut
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function verification($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($id))->getResult();

        return view('apps.test-letter.verification', $data);
    }

    /**
     * menerima permintaan terkait sut srut
     * @param Request $request
     * @return never
     */
    public function approve(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }


        $data = $request->only(['id','is_verified']);

        return $this->testLetterService->approve($data)->toJson();
    }

    /**
     * upload bpljskb
     * @param UploadPhysicalTestRequest $request
     * @return never
     */
    public function upload_physical_test_letter(UploadPhysicalTestRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['physical_test_bpljskb', 'id']);
        return $this->testLetterService->upload_physical_test_letter($data)->toJson();
    }

    /**
     * menampilkan detail bpljskb sut srut
     * @param Request $request
     * @return never
     */
    public function show_physical_test_letter(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(404);
        }

        return $this->testLetterService->findOrFail($request->id)->toJson();
    }

    /**
     * halaman permohonan permintaan srut
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function permohonan_sertifikat_srut_form($id)
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            $data['test_letter'] = @$this->testLetterService->find(Helper::decrypt($id))->getResult();
            return view('apps.test-letter.permohonan-srut-form', $data);
        }

        return abort(403);
    }

    /**
     * proses permohonan permintaan srut
     * @param FormPermohonanSRUTRequest $request
     * @return never
     */
    public function permohonan_sertifikat_srut_submit(FormPermohonanSRUTRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['permohonan_srut',
            'quality_control',
            'id',
        ]);
        return $this->testLetterService->upsert_permohonan_srut_form($data)->toJson();
    }

    /**
     * verifikasi srut
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function verification_srut($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($id))->getResult();

        return view('apps.test-letter.verification-srut', $data);
    }

    /**
     * menerima permintaan terkait srut
     * @param Request $request
     * @return never
     */
    public function approve_srut(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }


        $data = $request->only(['id','is_verified']);

        return $this->testLetterService->approve_srut($data)->toJson();
    }

    /**
     * proses form sut
     * @param FormHaveSUT $request
     * @return never
     */
    public function form_have_sut_submit(FormHaveSUT $request)
    {
        if (!auth()->user()->isGuest()) {
            return abort(403);
        }

        $data = $request->only(['workshop_type',
            'sop_component_installation',
            'technical_drawing',
            'conversion_workshop_certificate',
            'electrical_diagram',
            'photocopy_stnk',
            'physical_inspection',
            'test_report',
            'id',
            'responsible_person',
            'telephone',
            'address',
            'workshop','form_step',
            'conversion_type_test_application_letter',
            'type_test_attachment',
            'quality_control'
        ]);
        return $this->testLetterService->have_sut_form($data)->toJson();
    }

    /**
     * menolak permintaan terkait sut srut
     * @param Request $request
     * @return mixed
     */
    public function reject(Request $request)
    {
        $data = $request->only(['message', 'id', 'nohtml']);
        return $this->testLetterService->reject($data)->toJson();
    }
}
