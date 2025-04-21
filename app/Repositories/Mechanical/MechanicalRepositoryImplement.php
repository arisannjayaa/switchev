<?php

namespace App\Repositories\Mechanical;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Mechanical;

class MechanicalRepositoryImplement extends Eloquent implements MechanicalRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Mechanical $model)
    {
        $this->model = $model;
    }

    public function table($conversion_id)
    {
        return $this->model->query()
            ->with(['conversion'])
            ->when(auth()->user()->isAdmin(), function ($query) {
                $query->where('user_id', '!=', auth()->user()->id);
            })
            ->when(auth()->user()->isGuest(), function ($query) use ($conversion_id) {
                $query->where('user_id', auth()->user()->id);
                $query->where('conversion_id', $conversion_id);
            })
            ->orderBy('updated_at', 'desc');
    }

    public function checkIsAvailable($coonversion_id)
    {
        return $this->model->query()
            ->where('conversion_id', $coonversion_id)
            ->where('user_id', auth()->user()->id)->exists();
    }
}
