<?php

use App\Http\Controllers\Auth\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use  App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Users\InternCommentController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\MessageController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

});
Route::middleware('auth:admin')->group(function(){
    Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->middleware('can:manage-dashboard')
    ->name('admin.dashboard');

   
     Route::post('/admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');
    
     Route::middleware('can:manage-tasks')->group(function () {
        Route::prefix('admin/tasks')->name('admin.tasks.')->group(function () {
            Route::get('/', [TaskController::class, 'index'])->name('index');
            Route::get('/create', [TaskController::class, 'create'])->name('create');
            Route::post('/', [TaskController::class, 'store'])->name('store');
            Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
            Route::put('/{task}', [TaskController::class, 'update'])->name('update');
            Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        });
        
    });
    
  
    Route::post('admin/comment/store', [CommentController::class, 'store'])->name('admin.comment.store');

    
    Route::middleware(['can:manage-interns'])->group(function () {
        Route::prefix('admin/interns')->name('admin.interns.')->group(function () {
            Route::get('/', [InternController::class, 'index'])->name('index');
            Route::get('/create', [InternController::class, 'create'])->name('create');
            Route::post('/', [InternController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [InternController::class, 'edit'])->name('edit');
            Route::put('/{id}', [InternController::class, 'update'])->name('update');
            Route::delete('/{id}', [InternController::class, 'destroy'])->name('destroy');
        });
        
    });
    

    Route::middleware(['can:manage-roles'])->group(function () {
        Route::prefix('admin/roles')->name('admin.roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        });
        
    });
    
    
    Route::prefix('admin/messages')->name('admin.messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/chat/intern/{id}', [MessageController::class, 'openChat'])->name('chat');
        Route::post('/store', [MessageController::class, 'store'])->name('store');
        Route::get('/fetch/{intern_id}', [MessageController::class, 'fetch'])->name('fetch');
    });
    

    Route::middleware(['can:manage-users'])->prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [ManageUserController::class, 'index'])->name('index');
        Route::get('/create', [ManageUserController::class, 'create'])->name('create');
        Route::post('/', [ManageUserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ManageUserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ManageUserController::class, 'update'])->name('update');
        Route::delete('/{id}', [ManageUserController::class, 'destroy'])->name('destroy');
    });
    
});