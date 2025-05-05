<?php

use App\Http\Controllers\Auth\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminDashboardController;


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

});
Route::middleware('auth:admin')->group(function(){
    Route::get('/admin',[AdminDashboardController::class,'index'])->name('admin.dashbaord');
    Route::post('/admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');
});