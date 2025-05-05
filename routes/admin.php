<?php

use App\Http\Controllers\Auth\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use  App\Http\Controllers\Admin\TaskController;


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

});
Route::middleware('auth:admin')->group(function(){
    Route::get('/admin',[AdminDashboardController::class,'index'])->name('admin.dashboard');
   
     Route::post('/admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');
    
    Route::get('admin/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
    Route::get('admin/tasks/{task}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
    Route::put('admin/tasks/{task}', [TaskController::class, 'update'])->name('admin.tasks.update');
    Route::delete('admin/tasks/{task}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');
});