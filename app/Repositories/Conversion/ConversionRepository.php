<?php

namespace App\Repositories\Conversion;

use LaravelEasyRepository\Repository;

interface ConversionRepository extends Repository{

    public function checkIsConversion();

    public function findByUserId($userId);

    public function table();
}
