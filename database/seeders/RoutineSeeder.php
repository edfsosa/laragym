<?php

namespace Database\Seeders;

use App\Models\Routine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routines = [
            [
                'name' => 'Full Body Beginner',
                'description' => 'A beginner-friendly full body workout routine.',
                'level' => 'beginner',
                'duration_minutes' => 45,
            ],
            [
                'name' => 'Intermediate Strength Training',
                'description' => 'An intermediate routine focused on building strength.',
                'level' => 'intermediate',
                'duration_minutes' => 60,
            ],
            [
                'name' => 'Advanced HIIT',
                'description' => 'A high-intensity interval training routine for advanced users.',
                'level' => 'advanced',
                'duration_minutes' => 30,
            ]
        ];

        foreach ($routines as $routine) {
            Routine::create($routine);
        }

        $this->command->info('Routines seeded successfully!');
    }
}
