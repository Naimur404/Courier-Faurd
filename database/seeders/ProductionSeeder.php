<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds for production environment.
     */
    public function run(): void
    {
        $this->command->info('🚀 Setting up production data...');

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@courierfraud.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123456'),
                'email_verified_at' => now(),
            ]
        );

        // Create API subscription plans
        $plans = [
            [
                'name' => 'Basic Plan',
                'slug' => 'basic',
                'price' => 500.00,
                'duration_months' => 1,
                'request_limit' => 1000,
                'description' => 'Perfect for small businesses with basic API needs',
                'features' => json_encode([
                    '1000 API requests per month',
                    'Basic support',
                    'Standard response time'
                ]),
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional Plan',
                'slug' => 'professional',
                'price' => 1500.00,
                'duration_months' => 1,
                'request_limit' => 5000,
                'description' => 'Ideal for growing businesses with moderate API usage',
                'features' => json_encode([
                    '5000 API requests per month',
                    'Priority support',
                    'Fast response time',
                    'API analytics'
                ]),
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise Plan',
                'slug' => 'enterprise',
                'price' => 5000.00,
                'duration_months' => 1,
                'request_limit' => 25000,
                'description' => 'Comprehensive solution for large-scale operations',
                'features' => json_encode([
                    '25000 API requests per month',
                    '24/7 dedicated support',
                    'Premium response time',
                    'Advanced analytics',
                    'Custom integrations'
                ]),
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }

        $this->command->info('✅ Admin user created:');
        $this->command->info('   Email: admin@courierfraud.com');
        $this->command->info('   Password: admin123456');
        $this->command->warn('⚠️  IMPORTANT: Change the admin password immediately after deployment!');
        
        $this->command->info('✅ API subscription plans created:');
        $this->command->info('   - Basic Plan (৳500/month - 1000 requests)');
        $this->command->info('   - Professional Plan (৳1500/month - 5000 requests)');
        $this->command->info('   - Enterprise Plan (৳5000/month - 25000 requests)');
        
        $this->command->info('🎉 Production setup completed successfully!');
    }
}
