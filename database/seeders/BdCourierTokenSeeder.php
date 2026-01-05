<?php

namespace Database\Seeders;

use App\Models\BdCourierToken;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BdCourierTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Tokens should be added via admin panel at /admin/bd-courier-tokens
     * or by setting environment variables:
     * BDCOURIER_TOKEN_1, BDCOURIER_TOKEN_2, BDCOURIER_TOKEN_3, BDCOURIER_TOKEN_4
     */
    public function run(): void
    {
        // Load tokens from environment variables (don't hardcode secrets!)
        $envTokens = [
            ['name' => 'Token 1', 'env' => 'BDCOURIER_TOKEN_1', 'priority' => 1],
            ['name' => 'Token 2', 'env' => 'BDCOURIER_TOKEN_2', 'priority' => 2],
            ['name' => 'Token 3', 'env' => 'BDCOURIER_TOKEN_3', 'priority' => 3],
            ['name' => 'Token 4', 'env' => 'BDCOURIER_TOKEN_4', 'priority' => 4],
        ];

        $addedCount = 0;
        foreach ($envTokens as $tokenData) {
            $token = env($tokenData['env']);
            
            if ($token) {
                BdCourierToken::updateOrCreate(
                    ['token' => $token],
                    [
                        'name' => $tokenData['name'],
                        'token' => $token,
                        'priority' => $tokenData['priority'],
                        'is_active' => true,
                    ]
                );
                $addedCount++;
            }
        }

        if ($addedCount > 0) {
            $this->command->info("Added {$addedCount} BDCourier tokens from environment variables.");
        } else {
            $this->command->warn('No tokens found in environment variables. Add tokens via admin panel at /admin/bd-courier-tokens');
        }
    }
}
