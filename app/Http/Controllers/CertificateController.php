<?php

namespace App\Http\Controllers;

use App\Exports\DataKonversiExport;
use App\Helpers\Helper;
use App\Http\Requests\ExportDataConversion;
use App\Http\Requests\UploadArchiveRequest;
use App\Models\Certificate;
use App\Services\Certificate\CertificateService;
use App\Services\Conversion\ConversionService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class CertificateController extends Controller
{
    public function __construct(CertificateService $certificateService, ConversionService $conversionService)
    {
        $this->certificateService = $certificateService;
        $this->conversionService = $conversionService;
    }

    /**
     * generate file sertifikat konversi
     * @param Request $request
     * @return never
     */
    public function generate_certificate(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','accreditation_type']);
        return $this->certificateService->generate_certificate($data['id'], $data['accreditation_type'])->toJson();
    }

    /**
     * genereate file surat keterangan konversi
     * @param Request $request
     * @return never
     */
    public function generate_sk(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','accreditation_type']);
        return $this->certificateService->generate_sk($data['id'], $data['accreditation_type'])->toJson();
    }

    /**
     * upload file sertifikat dan surat keterangan konversi
     * @param UploadArchiveRequest $request
     * @return never
     */
    public function upload_archive(UploadArchiveRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','conversion_id','user_id','sk_attachment','sft_attachment', 'old_sk_attachment'
        ,'old_sft_attachment']);

        return $this->certificateService->upload_archive($data)->toJson();
    }

    /**
     * halaman upload sertifikat konversi
     * @param $conversion_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|never
     */
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

    /**
     * halaman daftar data sertifikat konversi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function index()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return view('apps.certificate.index');
    }

    /**
     * fetch data sertifikat konversi
     * @return never
     */
    public function table()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return $this->certificateService->table();
    }

    /**
     * halaman verifikasi draft
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function verify_draft_view($id)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data['certificate'] = Certificate::find(Helper::decrypt($id));

        return view('apps.certificate.verify-draft', $data);
    }

    /**
     * proses verifikasi draft
     * @param Request $request
     * @return never
     */
    public function verify_draft(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id']);
        return $this->certificateService->verify_draft($data['id'])->toJson();
    }

    /**
     * proses kirim draft ke superadmin
     * @param Request $request
     * @return never
     */
    public function send_draft(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','accreditation_type']);
        return $this->certificateService->send_draft($data['id'], $data['accreditation_type'])->toJson();
    }

    /**
     * export data sertifikat konversi
     * @param ExportDataConversion $request
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_data(ExportDataConversion $request)
    {
        $data = $request->only(['date_range', 'type', 'status']);
        return $this->certificateService->export($data)->toJson();
    }

}
