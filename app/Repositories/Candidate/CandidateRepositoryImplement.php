<?php

namespace App\Repositories\Candidate;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Candidate;

class CandidateRepositoryImplement extends Eloquent implements CandidateRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Candidate $model)
    {
        $this->model = $model;
    }

    public function paginate($page)
    {
        return $this->model->query()
            ->paginate($page);
    }
}
