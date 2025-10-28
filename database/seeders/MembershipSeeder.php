<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberships = [
            [
                'name' => 'Básica Mensual',
                'description' => 'Acceso a funciones básicas por un mes.',
                'price' => 100000.00,
                'duration_days' => 30,
            ],
            [
                'name' => 'Premium Mensual',
                'description' => 'Acceso completo por un mes con beneficios adicionales.',
                'price' => 200000.00,
                'duration_days' => 30,
            ],
            [
                'name' => 'Premium Anual',
                'description' => 'Acceso completo por un año con beneficios adicionales.',
                'price' => 2000000.00,
                'duration_days' => 365,
            ],
        ];

        foreach ($memberships as $membership) {
            Membership::create($membership);
        }

        $this->command->info('Memberships seeded successfully.');
    }
}
