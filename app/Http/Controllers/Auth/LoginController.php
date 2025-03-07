<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view ('apps.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->only(['email', 'password', 'remember']);
        return $this->authService->login($data)->toJson();
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login');
    }
}
