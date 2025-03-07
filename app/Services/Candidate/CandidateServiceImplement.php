<?php

namespace App\Services\Candidate;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Candidate\CandidateRepository;

class CandidateServiceImplement extends ServiceApi implements CandidateService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "Kandidat";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     */
     protected $delete_message = "berhasil dihapus.";

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(CandidateRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {
            $file = $data['photo'];
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newFileName = uniqid() . '.' . $extension;

            $filePath = $file->storeAs('documents', $newFileName, 'public');

            $data['photo'] = $filePath;
            $this->mainRepository->create($data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("Kandidat berhasil ditambahkan");
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
            $oldPhoto = @$data['old_photo'];

            if (@$_FILES['photo']['name']) {
                $path = storage_path('documents');

                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }

                $file = $data['photo'];
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $newFileName = uniqid() . '.' . $extension;

                $filePath = $file->storeAs('documents', $newFileName, 'public');

                $data['photo'] = $filePath;

                if (Storage::exists('documents/' . $oldPhoto)) {
                    Storage::delete('documents/' . $oldPhoto);
                }
            } else {
                $file_name = $oldPhoto;
                $data['photo'] = $file_name;
            }

            $this->mainRepository->update($id, $data);

            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("Kandidat berhasil diperbaharui");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($exception);
        }
    }

    public function paginate($page)
    {
        $result = $this->mainRepository->paginate($page);
        return $this->setStatus(true)
            ->setCode(200)
            ->setResult($result);
    }
}
