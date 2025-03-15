<?php

namespace App\Services\Mechanical;

use App\Repositories\Conversion\ConversionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Mechanical\MechanicalRepository;
use Yajra\DataTables\Facades\DataTables;

class MechanicalServiceImplement extends ServiceApi implements MechanicalService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

    protected $delete_message = "Berhasil dihapus";

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(MechanicalRepository $mainRepository, ConversionRepository $conversionRepository)
    {
      $this->mainRepository = $mainRepository;
      $this->conversionRepository = $conversionRepository;
    }

    public function table()
    {
        return DataTables::of($this->mainRepository->table())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $html = '<span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-circle-horizontal"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M8 12l0 .01" /><path d="M12 12l0 .01" /><path d="M16 12l0 .01" /></svg></button>
                              <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item edit" href="javascript:void(0)" data-id="'.$row->id.'">
                                  Edit
                                </a>
                                <a class="dropdown-item delete" href="javascript:void(0)" data-id="'.$row->id.'">
                                  Hapus
                                </a>
                              </div>
                            </span>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {
            $data['user_id'] = auth()->user()->id;
            $this->mainRepository->create($data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("Tenaga ahli berhasil ditambahkan");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($exception);
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            unset($data['id']);
            $this->mainRepository->update($id, $data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("Tenaga berhasil diperbaharui");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($exception);
        }
    }

    public function checkIsAvailable($data)
    {
        try {
            if ($this->mainRepository->checkIsAvailable()) {
                $step = $data['step'];
                $id = $data['id'];
                $data['step'] = 0;
                unset($data['id']);
                $this->conversionRepository->update($id, $data);
                $redirect = redirect()->intended(URL::route('conversion.form', ['step' => $step + 1]));
                return $this->setStatus(true)
                    ->setCode(200)
                    ->setResult(['redirect' => $redirect->getTargetUrl()]);
            }

            return $this->setStatus(false)
                ->setCode(403)
                ->setMessage("Minimal satu tenaga ahli harus ada");
        } catch (Exception $e) {
            return $this->exceptionResponse($exception);
        }
    }
}
