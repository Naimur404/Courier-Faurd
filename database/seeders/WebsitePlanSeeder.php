<?php

namespace Database\Seeders;

use App\Models\WebsitePlan;
use Illuminate\Database\Seeder;

class WebsitePlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Daily',
                'slug' => 'daily',
                'description' => '১ দিনের জন্য সীমাহীন সার্চ অ্যাক্সেস',
                'price' => 20,
                'duration_days' => 1,
                'icon' => 'Zap',
                'color' => 'blue',
                'features' => [
                    'সীমাহীন সার্চ',
                    'তাৎক্ষণিক ফলাফল',
                    'সকল কুরিয়ার ডেটা',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Weekly',
                'slug' => 'weekly',
                'description' => '১৫ দিনের জন্য সীমাহীন সার্চ অ্যাক্সেস',
                'price' => 50,
                'duration_days' => 15,
                'icon' => 'Crown',
                'color' => 'purple',
                'features' => [
                    'সীমাহীন সার্চ',
                    'তাৎক্ষণিক ফলাফল',
                    'সকল কুরিয়ার ডেটা',
                    'প্রাইওরিটি সাপোর্ট',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Monthly',
                'slug' => 'monthly',
                'description' => '৩০ দিনের জন্য সীমাহীন সার্চ অ্যাক্সেস',
                'price' => 100,
                'duration_days' => 30,
                'icon' => 'Star',
                'color' => 'indigo',
                'features' => [
                    'সীমাহীন সার্চ',
                    'তাৎক্ষণিক ফলাফল',
                    'সকল কুরিয়ার ডেটা',
                    'প্রাইওরিটি সাপোর্ট',
                    'বাল্ক সার্চ',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            WebsitePlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
