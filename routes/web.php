<?php

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MechanicalController;
use App\Http\Controllers\SecureFileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/register', [RegistrationController::class, 'index'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/registration', [RegistrationController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/s/{path}', [SecureFileController::class, 'index'])->name('secure.file');
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
        Route::post('/', [CandidateController::class, 'create'])->name('create');
        Route::post('/update', [CandidateController::class, 'update'])->name('update');
        Route::post('/delete', [CandidateController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [CandidateController::class, 'edit'])->name('edit');
        Route::get('/{id}', [CandidateController::class, 'show'])->name('show');
        Route::get('/form/{id}', [CandidateController::class, 'form'])->name('form');
    });

    // conversion
    Route::prefix('conversion')->name('conversion.')->group(function () {
        Route::get('/', [ConversionController::class, 'index'])->name('index');
        Route::post('/form', [ConversionController::class, 'formResponsibleWorkshop'])->name('form');
        Route::post('/upsert', [ConversionController::class, 'upsertFormResponsibleWorkshop'])->name('upsertFormResponsibleWorkshop');
        Route::post('/upsert/document', [ConversionController::class, 'upsertFormDocument'])->name('upsertFormDocument');
        Route::get('/table', [ConversionController::class, 'table'])->name('table');
        Route::post('/update', [ConversionController::class, 'update'])->name('update');
        Route::post('/delete', [ConversionController::class, 'delete'])->name('delete');
        Route::post('/approve', [ConversionController::class, 'approve'])->name('approve');
        Route::post('/reject', [ConversionController::class, 'reject'])->name('reject');
        Route::post('/send-mail-zoom', [ConversionController::class, 'sendZoomEmail'])->name('send-mail-zoom');
        Route::get('/form/step/{step}', [ConversionController::class, 'formResponsibleWorkshop'])->name('form');
        Route::get('/verification/{id}', [ConversionController::class, 'verification'])->name('verification');
        Route::get('/{id}', [ConversionController::class, 'show'])->name('show');
    });

    // mechanical
    Route::prefix('mechanical')->name('mechanical.')->group(function () {
        Route::get('/', [MechanicalController::class, 'index'])->name('index');
        Route::post('/', [MechanicalController::class, 'create'])->name('create');
        Route::get('/table', [MechanicalController::class, 'table'])->name('table');
        Route::post('/update', [MechanicalController::class, 'update'])->name('update');
        Route::post('/delete', [MechanicalController::class, 'delete'])->name('delete');
        Route::post('/check-available', [MechanicalController::class, 'checkIsAvailable'])->name('check.available');
        Route::get('/{id}', [MechanicalController::class, 'show'])->name('show');
    });

    // equipment
    Route::prefix('equipment')->name('equipment.')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('index');
        Route::post('/', [EquipmentController::class, 'create'])->name('create');
        Route::get('/table', [EquipmentController::class, 'table'])->name('table');
        Route::post('/update', [EquipmentController::class, 'update'])->name('update');
        Route::post('/delete', [EquipmentController::class, 'delete'])->name('delete');
        Route::post('/check-available', [EquipmentController::class, 'checkIsAvailable'])->name('check.available');
        Route::get('/{id}', [EquipmentController::class, 'show'])->name('show');
    });
});
