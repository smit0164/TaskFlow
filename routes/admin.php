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
        Route::get('admin/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
        Route::get('admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
        Route::get('admin/tasks/{task}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
        Route::put('admin/tasks/{task}', [TaskController::class, 'update'])->name('admin.tasks.update');
        Route::delete('admin/tasks/{task}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');
    });
    
  
    Route::post('admin/comment/store', [CommentController::class, 'store'])->name('admin.comment.store');

    
    Route::middleware(['can:manage-interns'])->group(function () {
        Route::get('/admin/interns', [InternController::class, 'index'])->name('admin.interns.index');
        Route::get('/admin/interns/create', [InternController::class, 'create'])->name('admin.interns.create');
        Route::post('/admin/interns', [InternController::class, 'store'])->name('admin.interns.store');
        Route::get('/admin/interns/{id}/edit', [InternController::class, 'edit'])->name('admin.interns.edit');
        Route::put('/admin/interns/{id}', [InternController::class, 'update'])->name('admin.interns.update');
        Route::delete('/admin/interns/{id}', [InternController::class, 'destroy'])->name('admin.interns.destroy');
    });
    

    Route::middleware(['can:manage-roles'])->group(function () {
        Route::get('admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('admin/roles', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    });
    
    
Route::get('/admin/messages', [MessageController::class, 'index'])->name('admin.messages.index');
Route::get('/chat/intern/{id}', [MessageController::class, 'openChat'])->name('admin.messages.chat');
Route::post('admin/messages/store', [MessageController::class, 'store'])->name('admin.messages.store');
Route::get('/admin/messages/fetch/{intern_id}', [MessageController::class, 'fetch'])->name('admin.messages.fetch');

    Route::middleware(['can:manage-users'])->prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [ManageUserController::class, 'index'])->name('index');
        Route::get('/create', [ManageUserController::class, 'create'])->name('create');
        Route::post('/', [ManageUserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ManageUserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ManageUserController::class, 'update'])->name('update');
        Route::delete('/{id}', [ManageUserController::class, 'destroy'])->name('destroy');
    });
    
});