<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadArchiveRequest;
use App\Services\Certificate\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    public function generate_certificate(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);

        return $this->certificateService->generate_certificate($data['id'])->toJson();
    }

    public function generate_sk(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);

        return $this->certificateService->generate_sk($data['id'])->toJson();
    }

    public function upload_archive(UploadArchiveRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['conversion_id','user_id','sk_attachment','sft_attachment', 'old_sk_attachment'
        ,'old_sft_attachment']);

        return $this->certificateService->upload_archive($data)->toJson();
    }

}
