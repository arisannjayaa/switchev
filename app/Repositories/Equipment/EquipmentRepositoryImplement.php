<?php

namespace App\Repositories\Equipment;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Equipment;

class EquipmentRepositoryImplement extends Eloquent implements EquipmentRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Equipment $model)
    {
        $this->model = $model;
    }

    public function table()
    {
        return $this->model->query()
            ->with(['conversion'])
            ->when(auth()->user()->isAdmin(), function ($query) {
                $query->where('user_id', '=', auth()->user()->id);
            })
            ->when(auth()->user()->isGuest(), function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->orderBy('updated_at', 'desc');
    }

    public function checkIsAvailable()
    {
        return $this->model->query()
            ->where('user_id', auth()->user()->id)->exists();
    }
}
