<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Exercise;
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
        // Seeding Routines
        $routines = [
            [
                'name' => 'Rutina de Fuerza para Principiantes',
                'description' => 'Una rutina básica para desarrollar fuerza muscular.',
                'level' => 'beginner',
                'duration_minutes' => 45,
                'type' => 'strength',
                'muscle_group' => 'full_body',
            ],
            [
                'name' => 'Cardio Intermedio',
                'description' => 'Mejora tu resistencia cardiovascular con esta rutina intermedia.',
                'level' => 'intermediate',
                'duration_minutes' => 30,
                'type' => 'cardio',
                'muscle_group' => null,
            ],
            [
                'name' => 'Flexibilidad Avanzada',
                'description' => 'Rutina avanzada para mejorar la flexibilidad y el rango de movimiento.',
                'level' => 'advanced',
                'duration_minutes' => 60,
                'type' => 'flexibility',
                'muscle_group' => null,
            ],
        ];

        foreach ($routines as $routine) {
            Routine::create($routine);
        }

        $this->command->info('Routines seeded successfully!');

        // Seeding Equipments
        $equipments = [
            [
                'id' => 1,
                'name' => 'Cinta de Correr',
                'description' => 'Cinta de correr de alta calidad para entrenamiento cardiovascular.',
                'type' => 'cardio',
                'serial_number' => 'TMX1000-2024',
                'brand' => 'FitGear',
                'model' => 'X1000',
                'status' => 'available',
                'purchased_at' => '2024-01-15',
                'purchase_price' => 1500000.00,
            ],
            [
                'id' => 2,
                'name' => 'Máquina de Pesas Multifuncional',
                'description' => 'Equipo versátil para entrenamiento de fuerza con múltiples estaciones.',
                'type' => 'strength',
                'serial_number' => 'MG2000-2024',
                'brand' => 'StrongFit',
                'model' => 'MultiPro 2000',
                'status' => 'available',
                'purchased_at' => '2024-02-20',
                'purchase_price' => 2500000.00,
            ],
            [
                'id' => 3,
                'name' => 'Bicicleta Estacionaria',
                'description' => 'Bicicleta estática para entrenamiento cardiovascular de bajo impacto.',
                'type' => 'cardio',
                'serial_number' => 'SB300-2024',
                'brand' => 'CycleMax',
                'model' => 'SpinPro 300',
                'status' => 'maintenance',
                'purchased_at' => '2024-03-10',
                'purchase_price' => 800000.00,
            ],
            [
                'id' => 4,
                'name' => 'Banco de Pesas Ajustable',
                'description' => 'Banco ajustable para diversos ejercicios de fuerza.',
                'type' => 'strength',
                'serial_number' => 'AB400-2024',
                'brand' => 'PowerLift',
                'model' => 'AdjustFit 400',
                'status' => 'available',
                'purchased_at' => '2024-04-05',
                'purchase_price' => 600000.00,
            ],
            [
                'id' => 5,
                'name' => 'Elíptica',
                'description' => 'Máquina elíptica para entrenamiento cardiovascular completo.',
                'type' => 'cardio',
                'serial_number' => 'EL500-2024',
                'brand' => 'EnduroFit',
                'model' => 'EllipPro 500',
                'status' => 'out_of_order',
                'purchased_at' => '2024-05-12',
                'purchase_price' => 1200000.00,
            ],
            [
                'id' => 6,
                'name' => 'Máquina de Remo',
                'description' => 'Equipo de remo para entrenamiento cardiovascular y de fuerza.',
                'type' => 'cardio',
                'serial_number' => 'RM600-2024',
                'brand' => 'RowMaster',
                'model' => 'RowerPro 600',
                'status' => 'available',
                'purchased_at' => '2024-06-18',
                'purchase_price' => 900000.00,
            ],
            [
                'id' => 7,
                'name' => 'Estación de Abdominales',
                'description' => 'Equipo especializado para ejercicios abdominales.',
                'type' => 'strength',
                'serial_number' => 'AB700-2024',
                'brand' => 'CoreFit',
                'model' => 'AbPro 700',
                'status' => 'available',
                'purchased_at' => '2024-07-22',
                'purchase_price' => 400000.00,
            ],
            [
                'id' => 8,
                'name' => 'Kettlebells',
                'description' => 'Conjunto de kettlebells de diferentes pesos para entrenamiento funcional.',
                'type' => 'strength',
                'serial_number' => 'KB800-2024',
                'brand' => 'FlexFit',
                'model' => 'KettleSet 800',
                'status' => 'available',
                'purchased_at' => '2024-08-30',
                'purchase_price' => 300000.00,
            ]
        ];

        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
        }

        $this->command->info('Equipment seeded successfully!');

        // Seeding Exercises
        $exercises = [
            [
                'equipment_id' => null,
                'name' => 'Flexiones de Brazo',
                'description' => 'Ejercicio básico para fortalecer el pecho y los tríceps.',
                'muscle_group' => 'Arms',
            ],
            [
                'equipment_id' => null,
                'name' => 'Sentadillas',
                'description' => 'Ejercicio fundamental para trabajar las piernas y glúteos.',
                'muscle_group' => 'Legs',
            ],
            [
                'equipment_id' => null,
                'name' => 'Plancha',
                'description' => 'Ejercicio isométrico para fortalecer el core.',
                'muscle_group' => 'Core',
            ],
            [
                'equipment_id' => 1,
                'name' => 'Correr en Cinta',
                'description' => 'Ejercicio cardiovascular en la cinta de correr.',
                'muscle_group' => 'Full Body',
            ],
            [
                'equipment_id' => 2,
                'name' => 'Press de Banca',
                'description' => 'Ejercicio de fuerza para el pecho utilizando la máquina de pesas.',
                'muscle_group' => 'Chest',
            ],
            [
                'equipment_id' => 3,
                'name' => 'Pedaleo en Bicicleta Estacionaria',
                'description' => 'Ejercicio cardiovascular utilizando la bicicleta estática.',
                'muscle_group' => 'Full Body',
            ],
            [
                'equipment_id' => 4,
                'name' => 'Press de Hombros en Banco Ajustable',
                'description' => 'Ejercicio de fuerza para los hombros utilizando el banco ajustable.',
                'muscle_group' => 'Shoulders',
            ],
            [
                'equipment_id' => 5,
                'name' => 'Entrenamiento en Elíptica',
                'description' => 'Ejercicio cardiovascular completo utilizando la máquina elíptica.',
                'muscle_group' => 'Full Body',
            ],
            [
                'equipment_id' => 6,
                'name' => 'Remo en Máquina de Remo',
                'description' => 'Ejercicio de fuerza y cardiovascular utilizando la máquina de remo.',
                'muscle_group' => 'Back',
            ],
            [
                'equipment_id' => 7,
                'name' => 'Crunches en Estación de Abdominales',
                'description' => 'Ejercicio para fortalecer los músculos abdominales utilizando la estación de abdominales.',
                'muscle_group' => 'Core',
            ],
            [
                'equipment_id' => 8,
                'name' => 'Kettlebell Swings',
                'description' => 'Ejercicio funcional utilizando kettlebells para trabajar todo el cuerpo.',
                'muscle_group' => 'Full Body',
            ],
            [
                'equipment_id' => 8,
                'name' => 'Goblet Squat con Kettlebell',
                'description' => 'Sentadilla sosteniendo una kettlebell para trabajar piernas y glúteos.',
                'muscle_group' => 'Legs',
            ],
            [
                'equipment_id' => 2,
                'name' => 'Jalón al Pecho en Máquina de Pesas',
                'description' => 'Ejercicio para fortalecer la espalda utilizando la máquina de pesas.',
                'muscle_group' => 'Back',
            ],
            [
                'equipment_id' => 4,
                'name' => 'Press de Banca Inclinado en Banco Ajustable',
                'description' => 'Ejercicio para el pecho superior utilizando el banco ajustable.',
                'muscle_group' => 'Chest',
            ],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }

        $this->command->info('Exercises seeded successfully!');

        // Seeding Routine-Exercise Relationships
        $routineExercises = [
            // Rutina de Fuerza para Principiantes
            ['routine_id' => 1, 'exercise_id' => 1],
            ['routine_id' => 1, 'exercise_id' => 2],
            ['routine_id' => 1, 'exercise_id' => 3],
            ['routine_id' => 1, 'exercise_id' => 5],
            ['routine_id' => 1, 'exercise_id' => 10],

            // Cardio Intermedio
            ['routine_id' => 2, 'exercise_id' => 4],
            ['routine_id' => 2, 'exercise_id' => 6],
            ['routine_id' => 2, 'exercise_id' => 9],
            ['routine_id' => 2, 'exercise_id' => 11],

            // Flexibilidad Avanzada
            ['routine_id' => 3, 'exercise_id' => 1],
            ['routine_id' => 3, 'exercise_id' => 2],
            ['routine_id' => 3, 'exercise_id' => 3],
            ['routine_id' => 3, 'exercise_id' => 12],
        ];

        foreach ($routineExercises as $re) {
            $routine = Routine::find($re['routine_id']);
            $routine->exercises()->attach($re['exercise_id']);
        }

        $this->command->info('Routine-Exercise relationships seeded successfully!');
    }
}
