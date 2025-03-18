<?php

namespace App\Repositories\Certificate;

use LaravelEasyRepository\Repository;

interface CertificateRepository extends Repository{

    public function findByUserId($user_id);
}
