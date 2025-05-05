<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'), // 🔐 Replace with secure password later
            'role_id' => 1, // Assuming '1' is 'super admin'
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
