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

    /**
     * @return mixed
     */
    public function table()
    {
        return $this->model->query()
            ->with(['test_letter','user'])
            ->when((auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()), function ($query) {
                return $query->whereIn('status',  ['Draft','Terverifikasi','Selesai','Draft SRUT','Draft SUT','Draft SRUT SUT','SUT Terverifikasi','SRUT Terverifikasi','SRUT SUT Terverifikasi']);
            })
            ->when(auth()->user()->isBpljskb(), function ($query) {
                return $query->whereIn('testing_status', ['Menunggu Hasil Uji', 'Hasil Uji Sudah Dibuat']);
            })
            ->when(request()->filled('status_test_letter'), function ($query) {
                $query->where('status', request()->status_test_letter);
            })
            ->when(request()->filled('date_range'), function ($query) {
                [$start, $end] = explode(' - ', request()->date_range);
                $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })
            ->when(request()->filled('workshop_type'), function ($query) {
                $query->whereHas('test_letter', function ($q) {
                    $q->where('workshop_type', request()->workshop_type);
                });
            })
            ->orderBy('updated_at', 'desc');
    }

    /**
     * @param $test_letter_id
     * @return mixed
     */
    public function findByTestLetterId($test_letter_id)
    {
        return $this->model->query()
            ->with(['test_letter','user'])
            ->where('test_letter_id', $test_letter_id)
            ->first();
    }

    public function findOrFail($id)
    {
        return $this->model->query()
            ->with(['test_letter','user'])
            ->where('id', $id)
            ->firstOrFail();
    }

    public function find($id)
    {
        return $this->model->query()
            ->with(['test_letter','user'])
            ->where('id', $id)
            ->first();
    }
}
