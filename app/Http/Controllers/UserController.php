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

    /**
     * halaman daftar data user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view('apps.user.index');
    }

    /**
     * fetch data user
     * @return never
     */
    public function table()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return $this->userService->table();
    }

    /**
     * buat user baru
     * @param UserRequest $request
     * @return never|string
     */
    public function create(UserRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['name','email','telephone','status']);
        return $this->userService->create($data)->toJson();
    }

    /**
     * menampilkan detail user
     * @param $id
     * @return never
     */
    public function show($id)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        return $this->userService->findOrFail($id)->toJson();
    }

    /**
     * update user
     * @param UserRequest $request
     * @return never
     */
    public function update(UserRequest $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(403);
        }

        $data = $request->only(['id','name','email','status']);
        return $this->userService->update($data['id'], $data)->toJson();
    }

    /**
     * hapus user
     * @param Request $request
     * @return never
     */
    public function delete(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return abort(404);
        }

        return $this->userService->delete($request->id)->toJson();
    }
}
