<?php

namespace App\Repositories\TestLetter;

use LaravelEasyRepository\Repository;

interface TestLetterRepository extends Repository{

    /**
     * @param $user_id
     * @return mixed
     */
    public function findAllByUserId();

    /**
     * @return mixed
     */
    public function table();

    public function getLastQueue();

    public function table_resume();
}
