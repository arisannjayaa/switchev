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

    /**
     * halaman registrasi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view ('apps.auth.registration');
    }

    /**
     * registrasi proses
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->only(['name', 'email', 'password', 'no_induk_berusaha', 'foto_fisik']);
        return $this->authService->register($data)->toJson();
    }
}
