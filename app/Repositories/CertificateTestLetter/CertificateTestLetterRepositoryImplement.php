<?php

namespace App\Repositories\CertificateTestLetter;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\CertificateTestLetter;

class CertificateTestLetterRepositoryImplement extends Eloquent implements CertificateTestLetterRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(CertificateTestLetter $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    /**
     * @return mixed
     */
    public function table()
    {
        return $this->model->query()
            ->with(['test_letter','user'])
            ->when((auth()->user()->isAdmin() && auth()->user()->isSuperAdmin()), function ($query) {
                return $query->whereIn('status',  ['Draft','Terverifikasi','Selesai','Draft SRUT','Draft SUT','Draft SRUT SUT','SUT Terverifikasi','SRUT Terverifikasi','SRUT SUT Terverifikasi']);
            })
            ->when(auth()->user()->isBpljskb(), function ($query) {
                return $query->whereIn('testing_status', ['Menunggu Hasil Uji', 'Hasil Uji Sudah Dibuat']);
            })
            ->orderBy('updated_at', 'desc');
    }

    /**
     * @param $test_letter_id
     * @return mixed
     */
    public function findByTestLetterId($test_letter_id)
    {
        return $this->model->query()
            ->with(['test_letter','user'])
            ->where('test_letter_id', $test_letter_id)
            ->first();
    }

    public function findOrFail($id)
    {
        return $this->model->query()
            ->with(['test_letter','user'])
            ->where('id', $id)
            ->firstOrFail();
    }
}
