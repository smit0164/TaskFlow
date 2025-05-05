<?php

use App\Http\Controllers\Auth\Users\UserAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UsersDashboardController;
// User authentication routes



Route::middleware("guest:intern")->group(function () {
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('intern.login');
    Route::post('login', [UserAuthController::class, 'login'])->name('intern.login.submit');
    Route::get('register', [UserAuthController::class, 'showRegisterForm'])->name('intern.register');
    Route::post('register', [UserAuthController::class, 'register'])->name('intern.register.submit');
    
});

Route::middleware("auth:intern")->group(function(){
    Route::post('logout',[UserAuthController::class, 'logout'])->name('intern.logout');
    Route::get('/',[UsersDashboardController::class,'index'])->name('intern.dashbaord');
});
require __DIR__ . '/admin.php';