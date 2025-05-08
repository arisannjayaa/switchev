<?php

namespace App\Services\Equipment;

use LaravelEasyRepository\BaseService;

interface EquipmentService extends BaseService{

    public function table($conversion_id);

    public function checkIsAvailable($data);
}
