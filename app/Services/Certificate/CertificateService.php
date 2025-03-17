<?php

namespace App\Services\Certificate;

use LaravelEasyRepository\BaseService;

interface CertificateService extends BaseService{

    public function generate_certificate($conversion_id);
    public function generate_sk($conversion_id);
}
