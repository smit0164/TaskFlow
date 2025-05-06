<?php

use App\Http\Controllers\Auth\Users\UserAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UsersDashboardController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Users\MessageController;
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
    Route::post('/comment/store', [CommentController::class, 'store'])->name('intern.comment.store');

    Route::get('/intern/admins', [UsersDashboardController::class, 'getAdmins'])->name('intern.admins');
    Route::get('/chat/admin/{admin_id}', [MessageController::class, 'show'])->name('intern.message.chat');
    Route::post('intern/messages/store', [MessageController::class, 'store'])->name('intern.messages.store');

    // Fetch messages for the intern (by admin_id)
    Route::get('intern/messages/fetch/{admin_id}', [MessageController::class, 'fetch'])->name('intern.messages.fetch');
});
require __DIR__ . '/admin.php';