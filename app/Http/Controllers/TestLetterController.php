<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\FormGenerateSpuRequest;
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

    public function index(Request $request)
    {
        $data['test_letters'] = $this->testLetterService->findAllByUserId()->getResult();
        return view('apps.test-letter.index', $data);
    }

    public function form(Request $request, $id = null)
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            $data['test_letter'] = @$this->testLetterService->find(Helper::decrypt($id))->getResult();
            return view('apps.test-letter.form', $data);
        }

        return abort(403);
    }

    public function generate_spu($id)
    {
        if (auth()->user()->isAdmin()) {
            $data['test_letter'] = @$this->testLetterService->findOrFail(Helper::decrypt($id))->getResult();
            return view('apps.test-letter.generate-spu', $data);
        }

        return abort(403);
    }

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

    public function table()
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->testLetterService->table();
    }

    public function show(Request $request)
    {
        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($request->id))->getResult();
        return view('apps.test-letter.detail', $data);
    }

    public function show_guest(Request $request)
    {
        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($request->id))->getResult();
        return view('apps.test-letter.detail-guest', $data);
    }

    public function verification($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($id))->getResult();

        return view('apps.test-letter.verification', $data);
    }

    public function approve(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }


        $data = $request->only(['id','is_verified']);

        return $this->testLetterService->approve($data)->toJson();
    }

    public function upload_physical_test_letter(UploadPhysicalTestRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['physical_test_bpljskb', 'id']);
        return $this->testLetterService->upload_physical_test_letter($data)->toJson();
    }

    public function show_physical_test_letter(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(404);
        }

        return $this->testLetterService->findOrFail($request->id)->toJson();
    }

    public function permohonan_sertifikat_srut_form($id)
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            $data['test_letter'] = @$this->testLetterService->find(Helper::decrypt($id))->getResult();
            return view('apps.test-letter.permohonan-srut-form', $data);
        }

        return abort(403);
    }

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

    public function verification_srut($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($id))->getResult();

        return view('apps.test-letter.verification-srut', $data);
    }

    public function approve_srut(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }


        $data = $request->only(['id','is_verified']);

        return $this->testLetterService->approve_srut($data)->toJson();
    }
}
