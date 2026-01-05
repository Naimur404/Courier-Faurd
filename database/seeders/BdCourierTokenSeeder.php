<?php

namespace Database\Seeders;

use App\Models\BdCourierToken;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BdCourierTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tokens = [
            [
                'name' => 'Token 1',
                'token' => 'bdc_ddsb5DmvKwfaQUHrgfduXahM5u7BZJaT66WsCdGmfqslhESGZEsZVirfVyrI',
                'priority' => 1,
            ],
            [
                'name' => 'Token 2',
                'token' => 'bdc_rYKpOfVFbm5a6HE121UK9OHcZcP6NRuYdw6kUVR3PJcQyjl8XpXpVHgJL7mA',
                'priority' => 2,
            ],
            [
                'name' => 'Token 3',
                'token' => 'toh3OAL9Vl1GV4xfo8tHCiZCW862udypeD3uS1ocNrBjLJYjALQcJRKRUYvY',
                'priority' => 3,
            ],
            [
                'name' => 'Token 4 (Fallback)',
                'token' => 'jcDS13SxRAtm69cANU9J1O0DjFKTlk24reQSFCsCw8EGOSG72lsgCz3R5TyG',
                'priority' => 4,
            ],
        ];

        foreach ($tokens as $tokenData) {
            BdCourierToken::updateOrCreate(
                ['token' => $tokenData['token']],
                $tokenData
            );
        }

        $this->command->info('BDCourier tokens seeded successfully!');
    }
}
