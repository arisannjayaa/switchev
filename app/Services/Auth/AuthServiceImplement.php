<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\URL;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;

class AuthServiceImplement extends ServiceApi implements AuthService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function login(array $data)
    {
        if(@!$data['remember']) {
            $data['remember'] = false;
        }

        if(auth()->attempt(['email' => $data['email'], 'password' => $data['password']], $data['remember'])) {
            $redirect = redirect()->intended(URL::route('dashboard'));
            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage('Login Berhasil')
                ->setResult(['redirect' => $redirect->getTargetUrl()]);
        } else {
            return $this->setStatus(false)
                ->setCode(401)
                ->setMessage('Email atau password salah');
        }
    }

    public function logout()
    {
        auth()->logout();
        return $this->setStatus(true)
            ->setCode(200)
            ->setMessage('Logout Berhasil');
    }
}
