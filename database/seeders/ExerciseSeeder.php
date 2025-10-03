<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exercises = [
            [
                'name' => 'Push-Up',
                'description' => 'A basic upper body strength exercise.',
                'muscle_group' => 'chest',
                'image_url' => 'push_up.jpg',
                'video_url' => 'https://example.com/push-up-demo',
                'equipment_id' => null
            ],
            [
                'name' => 'Squat',
                'description' => 'A fundamental lower body exercise.',
                'muscle_group' => 'legs',
                'image_url' => 'squat.jpg',
                'video_url' => 'https://example.com/squat-demo',
                'equipment_id' => null
            ],
            [
                'name' => 'Dumbbell Curl',
                'description' => 'An exercise targeting the biceps.',
                'muscle_group' => 'arms',
                'image_url' => 'dumbbell_curl.jpg',
                'video_url' => 'https://example.com/dumbbell-curl-demo',
                'equipment_id' => 2 // Assuming equipment with ID 2 is Dumbbell Set
            ],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }

        $this->command->info('Exercises seeded successfully.');
    }
}
