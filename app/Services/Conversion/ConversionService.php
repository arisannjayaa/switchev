<?php

namespace App\Services\Conversion;

use LaravelEasyRepository\BaseService;

interface ConversionService extends BaseService{

    public function checkStatusUser();

    public function checkConversion();
}
