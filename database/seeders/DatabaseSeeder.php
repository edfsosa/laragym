<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            MembershipSeeder::class,
            EquipmentSeeder::class,
            ExerciseSeeder::class,
            RoutineSeeder::class,
            FacilitySeeder::class,
            ServiceSeeder::class,
            TestimonySeeder::class,
            AchievementSeeder::class,
            LevelSeeder::class,
        ]);
    }
}
