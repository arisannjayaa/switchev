<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\MechanicalRequest;
use App\Services\Mechanical\MechanicalService;
use Illuminate\Http\Request;

class MechanicalController extends Controller
{
    public function __construct(MechanicalService $mechanicalService)
    {
        $this->mechanicalService = $mechanicalService;
    }

    /**
     * fetch data mekanik
     * @param $conversion_id
     * @return mixed
     */
    public function table($conversion_id)
    {
        return $this->mechanicalService->table(Helper::decrypt($conversion_id));
    }

    /**
     * tambah data mekanik
     * @param MechanicalRequest $request
     * @return never|string
     */
    public function create(MechanicalRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['conversion_id','name','task']);
        return $this->mechanicalService->create($data)->toJson();
    }

    /**
     * menampilkan detail data mekanik
     * @param $id
     * @return never
     */
    public function show($id)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->mechanicalService->findOrFail($id)->toJson();
    }

    /**
     * update data mekanik
     * @param MechanicalRequest $request
     * @return never
     */
    public function update(MechanicalRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','conversion_id','name','task']);
        return $this->mechanicalService->update($data['id'], $data)->toJson();
    }

    /**
     * hapus data mekanik
     * @param Request $request
     * @return never
     */
    public function delete(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(404);
        }

        return $this->mechanicalService->delete($request->id)->toJson();
    }

    /**
     * cek data mekanik
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
            'step_3_completed']);
        return $this->mechanicalService->checkIsAvailable($data)->toJson();
    }
}
