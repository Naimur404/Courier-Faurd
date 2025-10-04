<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@courierfraud.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123456'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        $this->command->info('Admin user created/updated successfully!');
        $this->command->info('Email: admin@courierfraud.com');
        $this->command->info('Password: admin123456');
        $this->command->info('Role: ' . $admin->role);
        $this->command->warn('⚠️  Please change the password after first login in production!');
    }
}
