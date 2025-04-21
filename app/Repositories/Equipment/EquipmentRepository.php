<?php

namespace App\Repositories\Equipment;

use LaravelEasyRepository\Repository;

interface EquipmentRepository extends Repository{

    public function table($conversion_id);

    public function checkIsAvailable($conversion_id);
}
