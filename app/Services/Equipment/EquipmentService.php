<?php

namespace App\Services\Equipment;

use LaravelEasyRepository\BaseService;

interface EquipmentService extends BaseService{

    public function table();

    public function checkIsAvailable($data);
}
