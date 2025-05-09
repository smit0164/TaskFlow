<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('private-chat.admin-{adminId}.intern-{internId}', function ($user, $adminId, $internId) {

    $admin = Auth::guard('admin')->user();
    $intern = Auth::guard('intern')->user();

    if ($admin && $admin->id == $adminId) {
        return true;
    }

    if ($intern && $intern->id == $internId) {
        return true;
    }
     return false;
});
