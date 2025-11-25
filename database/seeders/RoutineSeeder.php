<?php

namespace Database\Seeders;

use App\Models\Routine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Este seeder crea rutinas completas y realistas para diferentes niveles y objetivos.
     * Incluye 15 rutinas variadas:
     * - 5 rutinas de fuerza (strength)
     * - 4 rutinas de cardio
     * - 3 rutinas de flexibilidad/balance
     * - 3 rutinas full body
     */
    public function run(): void
    {
        // ==================== STRENGTH ROUTINES ====================

        // 1. Rutina Push (Pecho, Hombros, Tríceps) - Principiante
        $pushBeginner = Routine::create([
            'name' => 'Push Day - Principiante',
            'description' => 'Rutina enfocada en músculos de empuje: pecho, hombros y tríceps. Ideal para comenzar a desarrollar fuerza en el tren superior.',
            'level' => 'beginner',
            'duration_minutes' => 45,
            'type' => 'strength',
            'muscle_group' => 'upper_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $pushBeginner->id, 'exercise_id' => 7, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $pushBeginner->id, 'exercise_id' => 5, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $pushBeginner->id, 'exercise_id' => 39, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $pushBeginner->id, 'exercise_id' => 41, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $pushBeginner->id, 'exercise_id' => 32, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
        ]);

        // 2. Rutina Pull (Espalda, Bíceps) - Principiante
        $pullBeginner = Routine::create([
            'name' => 'Pull Day - Principiante',
            'description' => 'Rutina enfocada en músculos de tracción: espalda y bíceps. Desarrolla la fuerza de jalón y el grosor de la espalda.',
            'level' => 'beginner',
            'duration_minutes' => 45,
            'type' => 'strength',
            'muscle_group' => 'upper_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $pullBeginner->id, 'exercise_id' => 14, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $pullBeginner->id, 'exercise_id' => 17, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $pullBeginner->id, 'exercise_id' => 16, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $pullBeginner->id, 'exercise_id' => 27, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $pullBeginner->id, 'exercise_id' => 29, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
        ]);

        // 3. Rutina Piernas - Intermedio
        $legsIntermediate = Routine::create([
            'name' => 'Leg Day Completo - Intermedio',
            'description' => 'Rutina intensiva de piernas que trabaja cuádriceps, isquiotibiales, glúteos y pantorrillas. Incluye ejercicios compuestos y de aislamiento.',
            'level' => 'intermediate',
            'duration_minutes' => 60,
            'type' => 'strength',
            'muscle_group' => 'lower_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $legsIntermediate->id, 'exercise_id' => 20, 'sets' => 4, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 180, 'weight_kg' => 80.00, 'order' => 1],
            ['routine_id' => $legsIntermediate->id, 'exercise_id' => 23, 'sets' => 4, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => 100.00, 'order' => 2],
            ['routine_id' => $legsIntermediate->id, 'exercise_id' => 11, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => 60.00, 'order' => 3],
            ['routine_id' => $legsIntermediate->id, 'exercise_id' => 24, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $legsIntermediate->id, 'exercise_id' => 25, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 5],
            ['routine_id' => $legsIntermediate->id, 'exercise_id' => 34, 'sets' => 4, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 6],
        ]);

        // 4. Rutina Upper Body - Avanzado
        $upperAdvanced = Routine::create([
            'name' => 'Tren Superior Powerlifting - Avanzado',
            'description' => 'Rutina avanzada enfocada en fuerza máxima del tren superior. Incluye ejercicios compuestos con cargas pesadas.',
            'level' => 'advanced',
            'duration_minutes' => 75,
            'type' => 'strength',
            'muscle_group' => 'upper_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $upperAdvanced->id, 'exercise_id' => 1, 'sets' => 5, 'reps' => 5, 'duration_seconds' => null, 'rest_seconds' => 240, 'weight_kg' => 100.00, 'order' => 1],
            ['routine_id' => $upperAdvanced->id, 'exercise_id' => 15, 'sets' => 5, 'reps' => 5, 'duration_seconds' => null, 'rest_seconds' => 240, 'weight_kg' => 80.00, 'order' => 2],
            ['routine_id' => $upperAdvanced->id, 'exercise_id' => 2, 'sets' => 4, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 180, 'weight_kg' => 70.00, 'order' => 3],
            ['routine_id' => $upperAdvanced->id, 'exercise_id' => 12, 'sets' => 4, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $upperAdvanced->id, 'exercise_id' => 38, 'sets' => 4, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => 35.00, 'order' => 5],
            ['routine_id' => $upperAdvanced->id, 'exercise_id' => 8, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 6],
        ]);

        // 5. Rutina Lower Body - Avanzado
        $lowerAdvanced = Routine::create([
            'name' => 'Tren Inferior Hipertrofia - Avanzado',
            'description' => 'Rutina avanzada para desarrollo muscular de piernas. Combina ejercicios pesados con trabajo de volumen alto.',
            'level' => 'advanced',
            'duration_minutes' => 70,
            'type' => 'strength',
            'muscle_group' => 'lower_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $lowerAdvanced->id, 'exercise_id' => 11, 'sets' => 5, 'reps' => 6, 'duration_seconds' => null, 'rest_seconds' => 240, 'weight_kg' => 120.00, 'order' => 1],
            ['routine_id' => $lowerAdvanced->id, 'exercise_id' => 21, 'sets' => 4, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 180, 'weight_kg' => 50.00, 'order' => 2],
            ['routine_id' => $lowerAdvanced->id, 'exercise_id' => 23, 'sets' => 4, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => 150.00, 'order' => 3],
            ['routine_id' => $lowerAdvanced->id, 'exercise_id' => 24, 'sets' => 4, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $lowerAdvanced->id, 'exercise_id' => 26, 'sets' => 4, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
            ['routine_id' => $lowerAdvanced->id, 'exercise_id' => 34, 'sets' => 5, 'reps' => 20, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 6],
        ]);

        // ==================== CARDIO ROUTINES ====================

        // 6. HIIT Full Body - Principiante
        $hiitBeginner = Routine::create([
            'name' => 'HIIT Iniciación',
            'description' => 'Entrenamiento por intervalos de alta intensidad adaptado para principiantes. Combina ejercicios de peso corporal con descansos activos.',
            'level' => 'beginner',
            'duration_minutes' => 20,
            'type' => 'cardio',
            'muscle_group' => 'full_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $hiitBeginner->id, 'exercise_id' => 47, 'sets' => 3, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $hiitBeginner->id, 'exercise_id' => 5, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $hiitBeginner->id, 'exercise_id' => 22, 'sets' => 3, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $hiitBeginner->id, 'exercise_id' => 45, 'sets' => 3, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $hiitBeginner->id, 'exercise_id' => 37, 'sets' => 3, 'reps' => 20, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
        ]);

        // 7. HIIT Avanzado
        $hiitAdvanced = Routine::create([
            'name' => 'HIIT Extreme - Quema Grasa',
            'description' => 'Entrenamiento de alta intensidad extremo. Máxima quema calórica en mínimo tiempo. Solo para atletas avanzados.',
            'level' => 'advanced',
            'duration_minutes' => 30,
            'type' => 'cardio',
            'muscle_group' => 'full_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $hiitAdvanced->id, 'exercise_id' => 53, 'sets' => 4, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 20, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $hiitAdvanced->id, 'exercise_id' => 55, 'sets' => 4, 'reps' => null, 'duration_seconds' => 40, 'rest_seconds' => 20, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $hiitAdvanced->id, 'exercise_id' => 54, 'sets' => 4, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 20, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $hiitAdvanced->id, 'exercise_id' => 47, 'sets' => 4, 'reps' => null, 'duration_seconds' => 45, 'rest_seconds' => 20, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $hiitAdvanced->id, 'exercise_id' => 57, 'sets' => 4, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
        ]);

        // 8. Cardio Metabólico - Intermedio
        $metabolicCardio = Routine::create([
            'name' => 'Acondicionamiento Metabólico',
            'description' => 'Circuito diseñado para mejorar la capacidad cardiovascular y quemar grasa. Combina fuerza con resistencia.',
            'level' => 'intermediate',
            'duration_minutes' => 35,
            'type' => 'cardio',
            'muscle_group' => 'full_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $metabolicCardio->id, 'exercise_id' => 55, 'sets' => 3, 'reps' => 20, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $metabolicCardio->id, 'exercise_id' => 53, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $metabolicCardio->id, 'exercise_id' => 21, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $metabolicCardio->id, 'exercise_id' => 57, 'sets' => 3, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $metabolicCardio->id, 'exercise_id' => 47, 'sets' => 3, 'reps' => null, 'duration_seconds' => 40, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
        ]);

        // 9. Cardio y Core - Principiante
        $cardioCore = Routine::create([
            'name' => 'Cardio & Core Básico',
            'description' => 'Combinación de ejercicios cardiovasculares y trabajo de core. Ideal para fortalecer el abdomen y mejorar la resistencia.',
            'level' => 'beginner',
            'duration_minutes' => 25,
            'type' => 'cardio',
            'muscle_group' => 'core',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $cardioCore->id, 'exercise_id' => 37, 'sets' => 3, 'reps' => 30, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $cardioCore->id, 'exercise_id' => 45, 'sets' => 3, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $cardioCore->id, 'exercise_id' => 47, 'sets' => 3, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $cardioCore->id, 'exercise_id' => 44, 'sets' => 3, 'reps' => 20, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $cardioCore->id, 'exercise_id' => 46, 'sets' => 3, 'reps' => null, 'duration_seconds' => 20, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
        ]);

        // ==================== FLEXIBILITY & BALANCE ROUTINES ====================

        // 10. Core Fundamental - Principiante
        $coreBeginner = Routine::create([
            'name' => 'Core Fundamental',
            'description' => 'Rutina básica para desarrollar fuerza y estabilidad del core. Perfecta para principiantes o como calentamiento.',
            'level' => 'beginner',
            'duration_minutes' => 20,
            'type' => 'flexibility',
            'muscle_group' => 'core',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $coreBeginner->id, 'exercise_id' => 45, 'sets' => 3, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $coreBeginner->id, 'exercise_id' => 43, 'sets' => 3, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $coreBeginner->id, 'exercise_id' => 46, 'sets' => 3, 'reps' => null, 'duration_seconds' => 20, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $coreBeginner->id, 'exercise_id' => 52, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $coreBeginner->id, 'exercise_id' => 47, 'sets' => 2, 'reps' => 20, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
        ]);

        // 11. Core Avanzado
        $coreAdvanced = Routine::create([
            'name' => 'Core Elite - Six Pack',
            'description' => 'Rutina avanzada de core para desarrollar abdominales marcados y fuerza funcional extrema.',
            'level' => 'advanced',
            'duration_minutes' => 30,
            'type' => 'flexibility',
            'muscle_group' => 'core',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $coreAdvanced->id, 'exercise_id' => 48, 'sets' => 4, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 45, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $coreAdvanced->id, 'exercise_id' => 47, 'sets' => 4, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 45, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $coreAdvanced->id, 'exercise_id' => 44, 'sets' => 4, 'reps' => 30, 'duration_seconds' => null, 'rest_seconds' => 45, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $coreAdvanced->id, 'exercise_id' => 45, 'sets' => 3, 'reps' => 20, 'duration_seconds' => null, 'rest_seconds' => 45, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $coreAdvanced->id, 'exercise_id' => 45, 'sets' => 3, 'reps' => null, 'duration_seconds' => 60, 'rest_seconds' => 45, 'weight_kg' => null, 'order' => 5],
            ['routine_id' => $coreAdvanced->id, 'exercise_id' => 49, 'sets' => 3, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 6],
        ]);

        // 12. Balance y Estabilidad - Intermedio
        $balance = Routine::create([
            'name' => 'Balance y Estabilidad Funcional',
            'description' => 'Rutina para mejorar el equilibrio, la estabilidad y la coordinación. Excelente para prevención de lesiones.',
            'level' => 'intermediate',
            'duration_minutes' => 30,
            'type' => 'balance',
            'muscle_group' => 'full_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $balance->id, 'exercise_id' => 21, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $balance->id, 'exercise_id' => 26, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $balance->id, 'exercise_id' => 46, 'sets' => 3, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 30, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $balance->id, 'exercise_id' => 52, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 45, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $balance->id, 'exercise_id' => 16, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
        ]);

        // ==================== FULL BODY ROUTINES ====================

        // 13. Full Body Circuit - Principiante
        $fullBodyBeginner = Routine::create([
            'name' => 'Circuito Full Body - Principiante',
            'description' => 'Rutina de cuerpo completo para principiantes. Trabaja todos los grupos musculares principales en una sesión.',
            'level' => 'beginner',
            'duration_minutes' => 40,
            'type' => 'strength',
            'muscle_group' => 'full_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $fullBodyBeginner->id, 'exercise_id' => 22, 'sets' => 3, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 1],
            ['routine_id' => $fullBodyBeginner->id, 'exercise_id' => 5, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $fullBodyBeginner->id, 'exercise_id' => 14, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $fullBodyBeginner->id, 'exercise_id' => 39, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $fullBodyBeginner->id, 'exercise_id' => 45, 'sets' => 3, 'reps' => null, 'duration_seconds' => 30, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 5],
            ['routine_id' => $fullBodyBeginner->id, 'exercise_id' => 27, 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 6],
        ]);

        // 14. Full Body Strength - Intermedio
        $fullBodyIntermediate = Routine::create([
            'name' => 'Full Body Fuerza - Intermedio',
            'description' => 'Rutina de cuerpo completo enfocada en fuerza. Incluye los mejores ejercicios compuestos para desarrollo muscular.',
            'level' => 'intermediate',
            'duration_minutes' => 60,
            'type' => 'strength',
            'muscle_group' => 'full_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $fullBodyIntermediate->id, 'exercise_id' => 20, 'sets' => 4, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 180, 'weight_kg' => 70.00, 'order' => 1],
            ['routine_id' => $fullBodyIntermediate->id, 'exercise_id' => 1, 'sets' => 4, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 180, 'weight_kg' => 70.00, 'order' => 2],
            ['routine_id' => $fullBodyIntermediate->id, 'exercise_id' => 11, 'sets' => 3, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 180, 'weight_kg' => 80.00, 'order' => 3],
            ['routine_id' => $fullBodyIntermediate->id, 'exercise_id' => 12, 'sets' => 3, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => null, 'order' => 4],
            ['routine_id' => $fullBodyIntermediate->id, 'exercise_id' => 38, 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => 30.00, 'order' => 5],
            ['routine_id' => $fullBodyIntermediate->id, 'exercise_id' => 45, 'sets' => 3, 'reps' => null, 'duration_seconds' => 45, 'rest_seconds' => 60, 'weight_kg' => null, 'order' => 6],
        ]);

        // 15. CrossFit Style WOD - Avanzado
        $crossfitAdvanced = Routine::create([
            'name' => 'WOD CrossFit - Avanzado',
            'description' => 'Entrenamiento al estilo CrossFit de alta intensidad. Combina fuerza, potencia y acondicionamiento metabólico.',
            'level' => 'advanced',
            'duration_minutes' => 45,
            'type' => 'cardio',
            'muscle_group' => 'full_body',
        ]);

        DB::table('routine_exercises')->insert([
            ['routine_id' => $crossfitAdvanced->id, 'exercise_id' => 56, 'sets' => 5, 'reps' => 5, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => 60.00, 'order' => 1],
            ['routine_id' => $crossfitAdvanced->id, 'exercise_id' => 12, 'sets' => 5, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 2],
            ['routine_id' => $crossfitAdvanced->id, 'exercise_id' => 53, 'sets' => 5, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => null, 'order' => 3],
            ['routine_id' => $crossfitAdvanced->id, 'exercise_id' => 54, 'sets' => 5, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 90, 'weight_kg' => 20.00, 'order' => 4],
            ['routine_id' => $crossfitAdvanced->id, 'exercise_id' => 55, 'sets' => 5, 'reps' => 20, 'duration_seconds' => null, 'rest_seconds' => 120, 'weight_kg' => null, 'order' => 5],
        ]);

        $this->command->info('✅ 15 rutinas creadas exitosamente con sus ejercicios asociados.');
        $this->command->info('📊 Distribución: 5 Strength | 4 Cardio | 3 Flexibility/Balance | 3 Full Body');
    }
}
