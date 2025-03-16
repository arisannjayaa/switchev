<?php

namespace App\Repositories\Equipment;

use LaravelEasyRepository\Repository;

interface EquipmentRepository extends Repository{

    public function table();

    public function checkIsAvailable();
}
