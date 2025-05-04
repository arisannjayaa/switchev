<?php

namespace App\Services\CertificateTestLetter;

use LaravelEasyRepository\BaseService;

interface CertificateTestLetterService extends BaseService{

    public function generate_sk($test_letter_id);

    public function generate_certificate_srut($test_letter_id);

    public function generate_certificate_sut($test_letter_id);

    public function send_draft($test_letter_id);

    public function upsert_form_certificate($data);

    public function table();

    public function verify_draft($id);
}
