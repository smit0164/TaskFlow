<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    

    public function run()
    {
        $permissions = [
            // Dashboard Management
            ['name' => 'Manage Dashboard', 'slug' => 'manage-dashboard'],
        
            // Intern Management
            ['name' => 'Manage Interns', 'slug' => 'manage-interns'],
        
            // Task Management
            ['name' => 'Manage Tasks', 'slug' => 'manage-tasks'],
        
            // Role Management
            ['name' => 'Manage Roles', 'slug' => 'manage-roles'],
        
            // User Management
            ['name' => 'Manage Users', 'slug' => 'manage-users'],
        ];
        
    
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
    
}
