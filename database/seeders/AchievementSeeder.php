<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'Primer Entrenamiento Completado',
                'description' => 'Has completado tu primer entrenamiento en nuestro gimnasio.',
                'icon' => '🏋️‍♂️',
            ],
            [
                'name' => 'Asistencia Constante',
                'description' => 'Has asistido al gimnasio durante 30 días consecutivos.',
                'icon' => '📅',
            ],
            [
                'name' => 'Meta de Peso Alcanzada',
                'description' => 'Has alcanzado tu meta de peso establecida.',
                'icon' => '🎯',
            ],
            [
                'name' => 'Rutina Avanzada Completada',
                'description' => 'Has completado una rutina avanzada diseñada por nuestros entrenadores.',
                'icon' => '💪',
            ],
            [
                'name' => 'Desafío de Resistencia Superado',
                'description' => 'Has superado el desafío de resistencia mensual.',
                'icon' => '🏃‍♀️',
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }

        $this->command->info('Logros iniciales creados correctamente.');
    }
}
