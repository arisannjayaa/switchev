<?php

namespace App\Services\CertificateTestLetter;

use LaravelEasyRepository\BaseService;

interface CertificateTestLetterService extends BaseService{

    public function generate_sk($test_letter_id, $type);

    public function generate_certificate_srut($test_letter_id, $type);

    public function generate_certificate_sut($test_letter_id, $type);

    public function send_draft();
}
