<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function table()
    {
        return $this->model->query()
            ->with(['role'])
            ->when(auth()->user()->isAdmin(), function ($query) {
                $query->where('id', '!=', auth()->user()->id);
            })
            ->orderBy('updated_at', 'desc');
    }
}
