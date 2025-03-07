<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // user
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'create'])->name('create');
        Route::get('/table', [UserController::class, 'table'])->name('table');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/delete', [UserController::class, 'delete'])->name('delete');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
    });

    // candidate
    Route::prefix('candidate')->name('candidate.')->group(function () {
        Route::get('/', [CandidateController::class, 'index'])->name('index');
        Route::get('/form', [CandidateController::class, 'form'])->name('form');
        Route::post('/', [CandidateController::class, 'create'])->name('create');
        Route::post('/update', [CandidateController::class, 'update'])->name('update');
        Route::post('/delete', [CandidateController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [CandidateController::class, 'edit'])->name('edit');
        Route::get('/{id}', [CandidateController::class, 'show'])->name('show');
    });
});
