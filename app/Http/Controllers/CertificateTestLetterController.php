<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ExportDataTestLetter;
use App\Http\Requests\FormArchiveTestLetterCertificateRequest;
use App\Http\Requests\FormTestLetterCertificateRequest;
use App\Http\Requests\UploadArchiveRequest;
use App\Services\CertificateTestLetter\CertificateTestLetterService;
use App\Services\TestLetter\TestLetterService;
use Illuminate\Http\Request;

class CertificateTestLetterController extends Controller
{
    protected $testLetterService, $certificateTestLetterService;
    public function __construct(TestLetterService $testLetterService, CertificateTestLetterService $certificateTestLetterService)
    {
        $this->testLetterService = $testLetterService;
        $this->certificateTestLetterService = $certificateTestLetterService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function index()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return view('apps.certificate-test-letter.index');
    }

    /**
     * @return never
     */
    public function table()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return $this->certificateTestLetterService->table();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function certificate($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->findOrFail(Helper::decrypt($id))->getResult();

        return view('apps.test-letter.certificate', $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function certificate_srut($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->findOrFail(Helper::decrypt($id))->getResult();
        return view('apps.certificate-test-letter.generate-certificate-srut', $data);
    }


    /**
     * @param FormTestLetterCertificateRequest $request
     * @return never
     */
    public function certificate_form_submit(FormTestLetterCertificateRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only([
            'id',
            'test_letter_id',
            'brand',
            'vehicle_type',
            'type',
            'purpose_vehicle',
            'chassis',
            'machine',
            'goods_capacity',
            'electric_motor_number',
            'year_build',
            'axis_1_2',
            'axis_2_3',
            'axis_3_4',
            'width_total',
            'length_total',
            'height_total',
            'julur_front',
            'julur_rear',
            'power_max',
            'battery_max',
            'tire_axis_1',
            'tire_axis_2',
            'tire_axis_3',
            'tire_axis_4',
            'jbb',
            'empty_weight',
            'jbi',
            'carry_capacity',
            'road_class',
            'date_bpljskb',
            'place_test_bpljskb',
            'pengujian',
        ]);

        return $this->certificateTestLetterService->upsert_form_certificate($data)->toJson();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|never
     */
    public function generate($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->findOrFail(Helper::decrypt($id))->getResult();

        if ($data['test_letter']->certificate->status == "Selesai") {
            return redirect()->route('test.letter.index');
        }
        return view('apps.certificate-test-letter.generate-certificate', $data);
    }

    /**
     * @param Request $request
     * @return never
     */
    public function generate_certificate_srut(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);
        return $this->certificateTestLetterService->generate_certificate_srut($data['id'])->toJson();
    }

    /**
     * @param Request $request
     * @return never
     */
    public function generate_certificate_sut(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);
        return $this->certificateTestLetterService->generate_certificate_sut($data['id'])->toJson();
    }

    /**
     * @param Request $request
     * @return never
     */
    public function generate_sk(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);
        return $this->certificateTestLetterService->generate_sk($data['id'])->toJson();
    }

    /**
     * @param Request $request
     * @return never
     */
    public function send_draft(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);
        return $this->certificateTestLetterService->send_draft($data['id'])->toJson();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function verify_draft_view($id)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data['certificate'] = $this->certificateTestLetterService->findOrFail(Helper::decrypt($id))->getResult();
        return view('apps.certificate-test-letter.verify-draft', $data);
    }

    /**
     * @param Request $request
     * @return never
     */
    public function verify_draft(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);
        return $this->certificateTestLetterService->verify_draft($data['id'])->toJson();
    }

    /**
     * @param FormArchiveTestLetterCertificateRequest $request
     * @return \Illuminate\Http\JsonResponse|never
     */
    public function upload_archive(FormArchiveTestLetterCertificateRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','test_letter_id','user_id','sk_attachment','type_test_attachment', 'old_sk_attachment'
            ,'old_type_test_attachment','registration_attachment','old_registration_attachment', 'certificate_attachment',  'old_certificate_attachment']);

        return $this->certificateTestLetterService->upload_archive($data)->toJson();
    }

    /**
     * @param Request $request
     * @return never
     */
    public function generate_certificate_attachment(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);
        return $this->certificateTestLetterService->generate_certificate_attachment($data['id'])->toJson();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $data['certificate'] = $this->certificateTestLetterService->findOrFail(Helper::decrypt($request->id))->getResult();
        return view('apps.certificate-test-letter.detail', $data);
    }

    /**
     * @param Request $request
     * @return never
     */
    public function request_testing(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id', 'test_letter_id']);
        return $this->certificateTestLetterService->request_testing($data)->toJson();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function index_testing()
    {
        if (!auth()->user()->isBpljskb()) {
            return abort(403);
        }

        return view('apps.testing.index');
    }

    /**
     * @return never
     */
    public function table_testing()
    {
        if (!auth()->user()->isBpljskb()) {
            return abort(403);
        }

        return $this->certificateTestLetterService->table_testing();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function form_testing($id)
    {
        if (!auth()->user()->isBpljskb()) {
            return abort(403);
        }

        $data['test_letter'] = $this->certificateTestLetterService->findOrFail(Helper::decrypt($id))->getResult();
        return view('apps.testing.form', $data);
    }

    /**
     * @param Request $request
     * @return never
     */
    public function form_testing_submit(Request $request)
    {
        if (!auth()->user()->isBpljskb()) {
            return abort(403);
        }

        $data = $request->only(['id', 'pengujian']);

        return $this->certificateTestLetterService->form_testing_submit($data)->toJson();
    }

    /**
     * @param ExportDataTestLetter $request
     * @return mixed
     */
    public function export_data(ExportDataTestLetter $request)
    {
        $data = $request->only(['date_range', 'type', 'status']);
        return $this->certificateTestLetterService->export($data)->toJson();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function reject(Request $request)
    {
        $data = $request->only(['message', 'id', 'nohtml']);
        return $this->certificateTestLetterService->reject($data)->toJson();
    }
}
