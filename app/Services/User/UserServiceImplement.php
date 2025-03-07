<?php

namespace App\Services\User;

use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;
use Yajra\DataTables\Facades\DataTables;

class UserServiceImplement extends ServiceApi implements UserService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "User";


//     protected $create_message = "";
//     protected $update_message = "";
     protected $delete_message = "Berhasil dihapus";


     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
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
            $data['password'] = bcrypt($data['password']);
            $data['role_id'] = 2;
            $this->mainRepository->create($data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("User berhasil ditambahkan");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($exception);
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $data['password'] = bcrypt($data['password']);
            unset($data['id']);
            $this->mainRepository->update($id, $data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("User berhasil diperbaharui");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($exception);
        }
    }
}
