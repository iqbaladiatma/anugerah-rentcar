<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@anugerahrentcar.com',
            'phone' => '+62812345678',
            'role' => 'admin',
            'is_active' => true,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create staff user
        \App\Models\User::create([
            'name' => 'Staff User',
            'email' => 'staff@anugerahrentcar.com',
            'phone' => '+62812345679',
            'role' => 'staff',
            'is_active' => true,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create driver user
        \App\Models\User::create([
            'name' => 'Driver User',
            'email' => 'driver@anugerahrentcar.com',
            'phone' => '+62812345680',
            'role' => 'driver',
            'is_active' => true,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
