<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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

    public function form($id = null)
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            $data['test_letter'] = @$this->testLetterService->find($id)->getResult();
            return view('apps.test-letter.form', $data);
        }
    }

    public function upsert_form(FormTestLetterRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['type',
            'sop_component_installation',
            'technical_drawing',
            'conversion_workshop_certificate',
            'electrical_diagram',
            'photocopy_stnk',
            'physical_inspection',
            'test_report',
            'id']);
        return $this->testLetterService->upsert_form($data)->toJson();
    }

    public function table()
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->testLetterService->table();
    }

    public function show()
    {
        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt(request()->id))->getResult();
        return view('apps.test-letter.detail', $data);
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
}
