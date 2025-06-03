<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\FormTemplate;
use App\Http\Requests\MechanicalRequest;
use App\Services\Mechanical\MechanicalService;
use App\Services\TemplateCertificate\TemplateCertificateService;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    protected TemplateCertificateService $templateCertificateService;
    public function __construct(TemplateCertificateService $templateCertificateService)
    {
        $this->templateCertificateService = $templateCertificateService;
    }
    public function index()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return view('apps.template-certificate.index');
    }

    public function table()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return $this->templateCertificateService->table();
    }

    public function update(FormTemplate $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','attachment', 'old_attachment']);
        return $this->templateCertificateService->update(Helper::decrypt($data['id']), $data)->toJson();
    }

    public function form($id)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data['template'] = $this->templateCertificateService->findOrFail(Helper::decrypt($id))->getResult();
        return view('apps.template-certificate.form', $data);
    }

    public function detail($id)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data['template'] = $this->templateCertificateService->findOrFail(Helper::decrypt($id))->getResult();
        return view('apps.template-certificate.detail', $data);
    }
}
