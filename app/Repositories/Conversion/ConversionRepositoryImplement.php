<?php

namespace App\Repositories\Conversion;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Conversion;

class ConversionRepositoryImplement extends Eloquent implements ConversionRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Conversion $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function checkIsConversion()
    {
        return $this->model->query()->where('user_id', auth()->user()->id)->exists();
    }

    public function findByUserId($userId)
    {
        return $this->model->query()->where('user_id', $userId)->first();
    }

    public function table()
    {
        return $this->model->query()
            ->orderBy('updated_at', 'desc');
    }
}
