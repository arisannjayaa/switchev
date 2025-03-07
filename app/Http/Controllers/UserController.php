<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('apps.user.index');
    }

    public function table()
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->userService->table();
    }

    public function create(UserRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['name','email','password','telephone']);
        return $this->userService->create($data)->toJson();
    }

    public function show($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->userService->findOrFail($id)->toJson();
    }

    public function update(UserRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','name','email','password','telephone']);
        return $this->userService->update($data['id'], $data)->toJson();
    }

    public function delete(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(404);
        }

        return $this->userService->delete($request->id)->toJson();
    }
}
