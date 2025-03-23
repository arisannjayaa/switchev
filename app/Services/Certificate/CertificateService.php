<?php

namespace App\Services\Certificate;

use LaravelEasyRepository\BaseService;

interface CertificateService extends BaseService{

    public function generate_certificate($conversion_id, $accreditation_type);
    public function generate_sk($conversion_id, $accreditation_type);

    public function upload_archive($data);
}
