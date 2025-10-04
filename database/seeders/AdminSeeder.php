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
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@courierfraud.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123456'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@courierfraud.com');
        $this->command->info('Password: admin123456');
        $this->command->warn('⚠️  Please change the password after first login in production!');
    }
}
