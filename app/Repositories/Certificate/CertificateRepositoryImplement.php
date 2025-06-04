<?php

namespace App\Repositories\Certificate;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Certificate;

class CertificateRepositoryImplement extends Eloquent implements CertificateRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Certificate $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function findByUserId($user_id)
    {
        return $this->model->query()
            ->with(['user','conversion'])
            ->where('user_id', $user_id)
            ->first();
    }

    public function create($data)
    {
        return $this->model->query()
            ->with(['user','conversion'])
            ->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->query()
            ->with(['conversion','user'])
            ->where('id', $id)
            ->update($data);
    }

    /**
     * @param $conversion_id
     * @return mixed
     */
    public function findByConversionId($conversion_id)
    {
        return $this->model->query()
            ->with(['conversion','user'])
            ->where('conversion_id', $conversion_id)
            ->first();
    }

    public function table()
    {
        return $this->model->query()
            ->with(['conversion','user'])
            ->when(request()->filled('status_conversion'), function ($query) {
                $query->where('status', request()->status_conversion);
            })
            ->when(request()->filled('date_range'), function ($query) {
                [$start, $end] = explode(' - ', request()->date_range);
                $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })
            ->when(request()->filled('workshop_type'), function ($query) {
                $query->whereHas('conversion', function ($q) {
                    $q->where('type', request()->workshop_type);
                });
            })

            ->orderBy('updated_at', 'desc');
    }
}
