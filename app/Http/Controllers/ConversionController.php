<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversionRequest;
use App\Services\Conversion\ConversionService;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    protected $conversionService;
    public function __construct(ConversionService $conversionService)
    {
        $this->conversionService = $conversionService;
    }

    public function index()
    {
        return $this->conversionService->checkStatusUser();
    }

    public function form()
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            return view('apps.conversion.form');
        }
    }

    public function create(ConversionRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['type',
            'workshop',
            'address',
            'person_responsible',
            'whatapp_responsible',
            'application_letter',
            'technician_competency',
            'equipment',
            'sop',
            'wiring_diagram',
            'status']);
        return $this->conversionService->create($data)->toJson();
    }
}
