<?php

namespace Database\Seeders;

use App\Models\MembershipType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $membershipTypes = [
            [
                'name' => 'Basic',
                'description' => 'Access to basic features',
                'price' => 100000.00,
                'duration_days' => 30,
            ],
            [
                'name' => 'Premium',
                'description' => 'Access to all features',
                'price' => 250000.00,
                'duration_days' => 90,
            ],
            [
                'name' => 'VIP',
                'description' => 'All features plus VIP support',
                'price' => 500000.00,
                'duration_days' => 180,
            ],
        ];

        foreach ($membershipTypes as $type) {
            MembershipType::create($type);
        }

        $this->command->info('Membership types seeded successfully.');
    }
}
