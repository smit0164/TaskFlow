<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class AuthorizeProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $permissions = [
            'manage-dashboard',
            'manage-interns',
            'manage-tasks',
            'manage-roles',
            'manage-users',

        ];
        foreach ($permissions as $permission) {
            Gate::define($permission, function ($admin) use ($permission) {
                return $admin->hasPermission($permission);
            });
        }

        Gate::before(function ($admin, $permission) {
            return $admin->isSuperAdmin() ? true : null;
        });
    }
}
