<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ChecklistEquipmentRequest;
use App\Http\Requests\EquipmentRequest;
use App\Services\Equipment\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    /**
     * fetch data equipment
     * @param $conversion_id
     * @return mixed
     */
    public function table($conversion_id)
    {
        return $this->equipmentService->table(Helper::decrypt($conversion_id));
    }

    /**
     * tambah data equipment
     * @param EquipmentRequest $request
     * @return never|string
     */
    public function create(EquipmentRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['conversion_id','name','type','brand','specification']);
        return $this->equipmentService->create($data)->toJson();
    }

    /**
     * menampilkan detail data equipment
     * @param $id
     * @return never
     */
    public function show($id)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->equipmentService->findOrFail($id)->toJson();
    }

    /**
     * update data equipment
     * @param EquipmentRequest $request
     * @return never
     */
    public function update(EquipmentRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','conversion_id','name','type','brand','specification']);
        return $this->equipmentService->update($data['id'], $data)->toJson();
    }

    /**
     * menghapus data equipment
     * @param Request $request
     * @return never
     */
    public function delete(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(404);
        }

        return $this->equipmentService->delete($request->id)->toJson();
    }

    /**
     * cek data equipment
     * @param Request $request
     * @return never
     */
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
