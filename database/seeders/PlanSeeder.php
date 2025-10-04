<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'slug' => 'basic',
                'price' => 500.00,
                'duration_months' => 1,
                'request_limit' => 1000,
                'description' => 'Perfect for small projects and testing',
                'features' => [
                    '1,000 API requests per day',
                    'Basic courier tracking',
                    'Email support',
                    'Standard rate limiting'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional Plan',
                'slug' => 'professional',
                'price' => 2500.00,
                'duration_months' => 6,
                'request_limit' => 5000,
                'description' => 'Ideal for growing businesses',
                'features' => [
                    '5,000 API requests per day',
                    'Advanced courier tracking',
                    'Priority email support',
                    'Custom webhooks',
                    'Bulk operations'
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise Plan',
                'slug' => 'enterprise',
                'price' => 4500.00,
                'duration_months' => 12,
                'request_limit' => 15000,
                'description' => 'For large scale operations',
                'features' => [
                    '15,000 API requests per day',
                    'Real-time tracking',
                    '24/7 phone support',
                    'Custom integrations',
                    'Advanced analytics',
                    'Dedicated account manager'
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
