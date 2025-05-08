<?php

namespace App\Repositories\CertificateTestLetter;

use LaravelEasyRepository\Repository;

interface CertificateTestLetterRepository extends Repository{

    public function table();

    public function findByTestLetterId($test_letter_id);
}
