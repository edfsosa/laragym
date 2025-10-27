<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Área de Pesas',
                'description' => 'Área equipada con pesas libres, máquinas de resistencia y bancos para entrenamiento de fuerza. Perfecto para desarrollar músculo y tonificar el cuerpo.',
                'summary' => 'Equipado con pesas libres y máquinas de resistencia para entrenamiento de fuerza.',
                'sort_order' => 0
            ],
            [
                'name' => 'Zona Cardio',
                'description' => 'Área equipada con máquinas cardiovasculares como cintas de correr, bicicletas estáticas y elípticas. Ideal para mejorar la resistencia y la salud del corazón.',
                'summary' => 'Máquinas cardiovasculares para mejorar la resistencia y la salud del corazón.',
                'sort_order' => 1
            ],
            [
                'name' => 'Área Funcional',
                'description' => 'Espacio dedicado a ejercicios funcionales con equipamiento como balones medicinales, cuerdas de batalla y kettlebells. Perfecto para entrenamientos de alta intensidad y mejora de la movilidad.',
                'summary' => 'Equipamiento para ejercicios funcionales y entrenamientos de alta intensidad.',
                'sort_order' => 2
            ],
            [
                'name' => 'Salón de Yoga',
                'description' => 'Espacio tranquilo y relajante para clases de yoga, pilates y zumba. Equipado con colchonetas, bloques y otros accesorios para mejorar la flexibilidad y el bienestar mental.',
                'summary' => 'Clases de yoga, pilates y zumba en un ambiente relajante.',
                'sort_order' => 3
            ],
            [
                'name' => 'Baños y Vestuarios',
                'description' => 'Instalaciones limpias y modernas con duchas, taquillas y áreas de cambio para la comodidad de los usuarios.',
                'summary' => 'Duchas, taquillas y áreas de cambio modernas y limpias.',
                'sort_order' => 4
            ],
            [
                'name' => 'Climatización',
                'description' => 'Sistema de climatización que mantiene una temperatura agradable en todas las áreas del gimnasio, asegurando comodidad durante todo el año.',
                'summary' => 'Sistema de climatización para una temperatura agradable en todo el gimnasio.',
                'sort_order' => 5
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }

        $this->command->info('Facilities seeded successfully!');
    }
}
