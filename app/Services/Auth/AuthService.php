<?php

namespace App\Services\Auth;

use LaravelEasyRepository\BaseService;

interface AuthService extends BaseService{

    public function login(array $data);

    public function register($data);

    public function logout();

    public function change_password($data);

    public function update_account($data);
}
