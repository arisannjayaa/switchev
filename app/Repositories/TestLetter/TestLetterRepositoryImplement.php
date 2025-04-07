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

    /**
     * @param $user_id
     * @return mixed
     */
    public function findAllByUserId($user_id)
    {
        return $this->model->query()
            ->where('user_id', $user_id)
            ->paginate(10);
    }

    /**
     * @return mixed
     */
    public function table()
    {
        return $this->model->query()
            ->with(['user'])
            ->orderBy('updated_at', 'desc');
    }
}
