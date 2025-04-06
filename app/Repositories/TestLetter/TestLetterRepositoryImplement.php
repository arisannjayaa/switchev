<?php

namespace App\Repositories\TestLetter;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\TestLetter;

class TestLetterRepositoryImplement extends Eloquent implements TestLetterRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(TestLetter $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
