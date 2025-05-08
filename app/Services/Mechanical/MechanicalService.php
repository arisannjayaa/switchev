<?php

namespace App\Services\Mechanical;

use LaravelEasyRepository\BaseService;

interface MechanicalService extends BaseService{

    public function table($conversion_id);

    public function checkIsAvailable($data);
}
