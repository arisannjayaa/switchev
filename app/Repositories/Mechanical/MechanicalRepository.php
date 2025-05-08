<?php

namespace App\Repositories\Mechanical;

use LaravelEasyRepository\Repository;

interface MechanicalRepository extends Repository{

    public function table($conversion_id);

    public function checkIsAvailable($conversion_id);
}
