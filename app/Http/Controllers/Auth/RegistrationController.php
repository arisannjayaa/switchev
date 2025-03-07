<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use App\Http\Requests\RegisterRequest;

class RegistrationController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view ('apps.auth.registration');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->only(['name', 'email', 'password']);
        return $this->authService->register($data)->toJson();
    }
}
