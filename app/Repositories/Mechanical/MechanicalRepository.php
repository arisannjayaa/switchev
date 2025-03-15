<?php

namespace App\Repositories\Mechanical;

use LaravelEasyRepository\Repository;

interface MechanicalRepository extends Repository{

    public function table();

    public function checkIsAvailable();
}
