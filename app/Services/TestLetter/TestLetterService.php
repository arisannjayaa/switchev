<?php

namespace App\Services\TestLetter;

use LaravelEasyRepository\BaseService;

interface TestLetterService extends BaseService{

    public function upsert_form($data);

    public function findAllByUserId($user_id);
}
