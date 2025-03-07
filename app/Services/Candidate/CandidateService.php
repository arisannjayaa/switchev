<?php

namespace App\Services\Candidate;

use LaravelEasyRepository\BaseService;

interface CandidateService extends BaseService{

    public function paginate($page);
}
