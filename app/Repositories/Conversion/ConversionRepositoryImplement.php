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

    public function findByUserId($userId, $id)
    {
        return $this->model->query()
            ->with(['user','mechanicals','equipments','certificate'])
            ->where('user_id', $userId)
            ->where('id', $id)
            ->first();
    }

    public function table()
    {
        return $this->model->query()
            ->with(['certificate', 'user'])
            ->when(auth()->user()->isGuest(), function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->orderBy('updated_at', 'desc');
    }

    public function find($id)
    {
        return $this->model->query()
            ->with(['user','mechanicals','equipments','certificate'])
            ->where('id', $id)
            ->first();
    }

    /**
     * @return mixed
     */
    public function getLastQueue()
    {
        return $this->model->query()
            ->orderBy('queue_number', 'desc')
            ->first();
    }
}
