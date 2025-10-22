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
                'name' => 'Basic Membership',
                'description' => 'Access to basic features and content.',
                'price' => 100000.00,
                'duration_days' => 30,
            ],
            [
                'name' => 'Premium Membership',
                'description' => 'Access to all features and premium content.',
                'price' => 200000.00,
                'duration_days' => 30,
            ],
            [
                'name' => 'Annual Membership',
                'description' => 'Full access for a year with a discount.',
                'price' => 1000000.00,
                'duration_days' => 365,
            ],
        ];

        foreach ($memberships as $membership) {
            Membership::create($membership);
        }

        $this->command->info('Memberships seeded successfully.');
    }
}
