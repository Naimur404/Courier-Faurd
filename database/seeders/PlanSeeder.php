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
                'name' => 'স্টার্ট',
                'slug' => 'start-50',
                'price' => 100.00,
                'monthly_price' => 100.00,
                'yearly_price' => 1000.00,
                'duration_months' => 1,
                'billing_period' => 'monthly',
                'request_limit' => 1500,
                'daily_limit' => 50,
                'description' => 'ছোট টিমের জন্য - Daily 50 সার্চ',
                'features' => [
                    'দৈনিক ৫০ সার্চ',
                    'Premium Support',
                    'Free API Access',
                    'Bulk Search Enabled',
                    'Google Sheet Integration',
                    'Free WordPress Plugin',
                    'Free Android Apps',
                ],
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'গ্রোথ',
                'slug' => 'growth-100',
                'price' => 199.00,
                'monthly_price' => 199.00,
                'yearly_price' => 1999.00,
                'duration_months' => 1,
                'billing_period' => 'monthly',
                'request_limit' => 3000,
                'daily_limit' => 100,
                'description' => 'স্কেলিং ব্যবসা - Daily 100 সার্চ',
                'features' => [
                    'দৈনিক ১০০ সার্চ',
                    'Premium Support',
                    'Free API Access',
                    'Bulk Search Enabled',
                    'Google Sheet Integration',
                    'Free WordPress Plugin',
                    'Free Android Apps',
                    'Priority Processing',
                ],
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'প্রো',
                'slug' => 'pro-500',
                'price' => 349.00,
                'monthly_price' => 349.00,
                'yearly_price' => 3499.00,
                'duration_months' => 1,
                'billing_period' => 'monthly',
                'request_limit' => 15000,
                'daily_limit' => 500,
                'description' => 'অপারেশন-হেভি টিম - Daily 500 সার্চ',
                'features' => [
                    'দৈনিক ৫০০ সার্চ',
                    'Premium Support',
                    'Free API Access',
                    'Bulk Search Enabled',
                    'Google Sheet Integration',
                    'Free WordPress Plugin',
                    'Free Android Apps',
                    'Priority Processing',
                    'Advanced Analytics',
                ],
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'ম্যাক্স',
                'slug' => 'max-1000',
                'price' => 500.00,
                'monthly_price' => 500.00,
                'yearly_price' => 5000.00,
                'duration_months' => 1,
                'billing_period' => 'monthly',
                'request_limit' => 30000,
                'daily_limit' => 1000,
                'description' => 'হাই-ভলিউম টিম - Daily 1000 সার্চ',
                'features' => [
                    'দৈনিক ১০০০ সার্চ',
                    'Premium Support',
                    'Free API Access',
                    'Bulk Search Enabled',
                    'Google Sheet Integration',
                    'Free WordPress Plugin',
                    'Free Android Apps',
                    'Priority Processing',
                    'Advanced Analytics',
                    'Dedicated Account Manager',
                ],
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
