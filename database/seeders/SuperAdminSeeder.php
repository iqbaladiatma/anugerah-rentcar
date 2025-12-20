<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@anugerah-rentcar.com',
            'password' => bcrypt('SuperAdmin123!'),
            'phone' => '081234567890',
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Super Admin account created successfully!');
        $this->command->info('Email: superadmin@anugerah-rentcar.com');
        $this->command->info('Password: SuperAdmin123!');
        $this->command->warn('Please change the password after first login!');
    }
}
