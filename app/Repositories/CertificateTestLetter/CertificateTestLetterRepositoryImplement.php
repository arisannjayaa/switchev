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
            ->whereIn('status',  ['Draft','Terverifikasi','Selesai'])
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
}
