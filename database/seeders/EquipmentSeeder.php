<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipments = [
            [
                'name' => 'Treadmill',
                'description' => 'High-quality treadmill for cardio workouts',
                'type' => 'cardio',
                'image' => 'treadmill.jpg',
                'video_url' => 'https://example.com/treadmill-demo',
                'serial_number' => 'TM123456',
                'brand' => 'FitBrand',
                'model' => 'X1000',
                'status' => 'available',
                'purchased_at' => '2023-01-15',
                'purchase_price' => 2500000.00,
            ],
            [
                'name' => 'Dumbbell Set',
                'description' => 'Adjustable dumbbell set for strength training',
                'type' => 'strength',
                'image' => 'dumbbells.jpg',
                'video_url' => 'https://example.com/dumbbell-demo',
                'serial_number' => 'DB654321',
                'brand' => 'StrongFit',
                'model' => 'DumbX',
                'status' => 'available',
                'purchased_at' => '2023-03-10',
                'purchase_price' => 1500000.00,
            ],
            [
                'name' => 'Leg Press Machine',
                'description' => 'Machine for lower body strength training',
                'type' => 'strength',
                'image' => 'leg_press.jpg',
                'video_url' => 'https://example.com/legpress-demo',
                'serial_number' => 'LP789012',
                'brand' => 'PowerLift',
                'model' => 'LegPro2000',
                'status' => 'available',
                'purchased_at' => '2023-05-20',
                'purchase_price' => 3000000.00,
            ],
        ];

        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
        }

        $this->command->info('Equipment seeded successfully.');
    }
}
