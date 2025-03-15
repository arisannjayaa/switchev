<?php

namespace App\Services\Mechanical;

use LaravelEasyRepository\BaseService;

interface MechanicalService extends BaseService{

    public function table();

    public function checkIsAvailable($data);
}
