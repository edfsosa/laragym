<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Novato',
                'min_xp' => 0,
                'description' => 'Bienvenido al gimnasio. Estás comenzando tu viaje hacia tu mejor versión.',
            ],
            [
                'name' => 'Intermedio',
                'min_xp' => 500,
                'description' => 'Has demostrado dedicación y constancia. Sigue así para alcanzar nuevas metas.',
            ],
            [
                'name' => 'Avanzado',
                'min_xp' => 1500,
                'description' => 'Tu esfuerzo es evidente. Estás en el camino correcto hacia un estilo de vida saludable.',
            ],
            [
                'name' => 'Experto',
                'min_xp' => 3000,
                'description' => 'Eres un ejemplo a seguir. Tu compromiso con el fitness es inspirador.',
            ],
            [
                'name' => 'Leyenda',
                'min_xp' => 5000,
                'description' => 'Has alcanzado la cima. Eres una leyenda del gimnasio y un modelo de perseverancia.',
            ],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }

        $this->command->info('Niveles de experiencia creados exitosamente.');
    }
}
