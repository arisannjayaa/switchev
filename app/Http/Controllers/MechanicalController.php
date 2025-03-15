<?php

namespace App\Http\Controllers;

use App\Http\Requests\MechanicalRequest;
use App\Services\Mechanical\MechanicalService;
use Illuminate\Http\Request;

class MechanicalController extends Controller
{
    public function __construct(MechanicalService $mechanicalService)
    {
        $this->mechanicalService = $mechanicalService;
    }
    public function index()
    {
        return view('apps.user.index');
    }

    public function table()
    {
        return $this->mechanicalService->table();
    }

    public function create(MechanicalRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['conversion_id','name','task']);
        return $this->mechanicalService->create($data)->toJson();
    }

    public function show($id)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->mechanicalService->findOrFail($id)->toJson();
    }

    public function update(MechanicalRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','conversion_id','name','task']);
        return $this->mechanicalService->update($data['id'], $data)->toJson();
    }

    public function delete(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(404);
        }

        return $this->mechanicalService->delete($request->id)->toJson();
    }

    public function checkIsAvailable(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only([
            'id',
            'step',
            'step_3_completed']);
        return $this->mechanicalService->checkIsAvailable($data)->toJson();
    }
}
