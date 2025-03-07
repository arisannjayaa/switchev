<?php

namespace App\Repositories\Candidate;

use LaravelEasyRepository\Repository;

interface CandidateRepository extends Repository{

    public function paginate($page);
}
