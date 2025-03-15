<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentRequest;
use App\Services\Equipment\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }
    public function index()
    {
        return view('apps.user.index');
    }

    public function table()
    {
        return $this->equipmentService->table();
    }

    public function create(EquipmentRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['conversion_id','name','type','brand','specification']);
        return $this->equipmentService->create($data)->toJson();
    }

    public function show($id)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->equipmentService->findOrFail($id)->toJson();
    }

    public function update(EquipmentRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','conversion_id','name','type','brand','specification']);
        return $this->equipmentService->update($data['id'], $data)->toJson();
    }

    public function delete(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(404);
        }

        return $this->equipmentService->delete($request->id)->toJson();
    }

    public function checkIsAvailable(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only([
            'id',
            'step',
            'step_4_completed']);
        return $this->equipmentService->checkIsAvailable($data)->toJson();
    }
}
