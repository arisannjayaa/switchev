<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\FormGenerateSpuRequest;
use App\Http\Requests\FormHaveSUT;
use App\Http\Requests\FormPermohonanSRUTRequest;
use App\Http\Requests\FormSendSpuRequest;
use App\Http\Requests\FormTestLetterRequest;
use App\Http\Requests\UploadPhysicalTestRequest;
use App\Services\TestLetter\TestLetterService;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    protected TestLetterService $testLetterService;
    public function __construct(TestLetterService $testLetterService)
    {
        $this->testLetterService = $testLetterService;
    }

    public function index(Request $request)
    {
        if (!auth()->user()->isBpljskb()) {
            return abort(403);
        }

        return view('apps.resume.index');
    }

    public function table()
    {
        if (!auth()->user()->isBpljskb()) {
            return abort(403);
        }

        return $this->testLetterService->table_resume();
    }

    public function upload_physical_test_letter(UploadPhysicalTestRequest $request)
    {
        if (!auth()->user()->isBpljskb()) {
            return abort(403);
        }

        $data = $request->only(['physical_test_bpljskb', 'id']);
        return $this->testLetterService->upload_physical_test_letter($data)->toJson();
    }

    public function show_physical_test_letter(Request $request)
    {
        if (!auth()->user()->isBpljskb()) {
            return abort(404);
        }

        return $this->testLetterService->findOrFail($request->id)->toJson();
    }
}
