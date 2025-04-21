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
}
