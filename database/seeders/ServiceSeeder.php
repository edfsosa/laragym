<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Entrenamiento Personalizado',
                'description' => 'Sesiones de entrenamiento adaptadas a tus necesidades y objetivos. Nuestros entrenadores certificados te guiarán en cada paso del camino.',
                'summary' => 'Entrenamiento uno a uno con un entrenador certificado.',
                'sort_order' => 0,
            ],
            [
                'name' => 'Evaluación Inicial',
                'description' => 'Evaluación completa de tu estado físico actual para diseñar un plan de entrenamiento efectivo y seguro.',
                'summary' => 'Evaluación física completa para nuevos miembros.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Asesoramiento Nutricional',
                'description' => 'Planes de alimentación personalizados para complementar tu régimen de entrenamiento y ayudarte a alcanzar tus objetivos de salud.',
                'summary' => 'Planes de alimentación personalizados.',
                'sort_order' => 2,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('Services table seeded successfully.');
    }
}
