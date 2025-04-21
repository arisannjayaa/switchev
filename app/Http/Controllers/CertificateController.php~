<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\UploadArchiveRequest;
use App\Models\Certificate;
use App\Services\Certificate\CertificateService;
use App\Services\Conversion\ConversionService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(CertificateService $certificateService, ConversionService $conversionService)
    {
        $this->certificateService = $certificateService;
        $this->conversionService = $conversionService;
    }

    public function generate_certificate(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','accreditation_type']);
        return $this->certificateService->generate_certificate($data['id'], $data['accreditation_type'])->toJson();
    }

    public function generate_sk(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','accreditation_type']);
        return $this->certificateService->generate_sk($data['id'], $data['accreditation_type'])->toJson();
    }

    public function upload_archive(UploadArchiveRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','conversion_id','user_id','sk_attachment','sft_attachment', 'old_sk_attachment'
        ,'old_sft_attachment']);

        return $this->certificateService->upload_archive($data)->toJson();
    }

    public function certification_form($conversion_id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['conversion'] = $this->conversionService->find(Helper::decrypt($conversion_id))->getResult();
        if (@$data['conversion']->certificate->status == 'Selesai') {
            return redirect()->route('conversion.index');
        }

        return view('apps.conversion.certification', $data);
    }

    public function index()
    {
        return view('apps.certificate.index');
    }

    public function table()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return $this->certificateService->table();
    }

    public function verify_draft_view($id)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data['certificate'] = Certificate::find(Helper::decrypt($id));

        return view('apps.certificate.verify-draft', $data);
    }

    public function verify_draft(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);
        return $this->certificateService->verify_draft($data['id'])->toJson();
    }

    public function send_draft(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','accreditation_type']);
        return $this->certificateService->send_draft($data['id'], $data['accreditation_type'])->toJson();
    }

}
