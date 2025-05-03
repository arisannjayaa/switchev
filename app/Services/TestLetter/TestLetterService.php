<?php

namespace App\Services\TestLetter;

use LaravelEasyRepository\BaseService;

interface TestLetterService extends BaseService{

    public function upsert_form($data);

    public function findAllByUserId();

    public function table();

    public function approve($data);

    public function generate_physical_test_cover_letter();

    public function upload_physical_test_letter($data);

    public function generate_spu($data);

    public function send_spu($data);
}
