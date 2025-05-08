<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('private-chat.admin-{adminId}.intern-{internId}', function ($user, $adminId, $internId) {

    $admin = Auth::guard('admin')->user();
    $intern = Auth::guard('intern')->user();

    Log::info('Channel authorization attempt', [
        'auth_user_id' => $user->id,
        'admin_guard_id' => $admin?->id,
        'intern_guard_id' => $intern?->id,
        'channel_admin_id' => $adminId,
        'channel_intern_id' => $internId,
    ]);

    if ($admin && $admin->id == $adminId) {
        return true;
    }

    if ($intern && $intern->id == $internId) {
        return true;
    }

    return false;
});
