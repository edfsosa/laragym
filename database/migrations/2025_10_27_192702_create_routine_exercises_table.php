<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routine_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('routine_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('sets')->nullable(); // Número de series
            $table->unsignedTinyInteger('reps')->nullable(); // Número de repeticiones (para ejercicios basados en repeticiones)
            $table->unsignedSmallInteger('duration_seconds')->nullable(); // Duración en segundos (para ejercicios basados en tiempo)
            $table->unsignedSmallInteger('rest_seconds')->nullable(); // Tiempo de descanso entre series en segundos
            $table->decimal('weight_kg', 5, 2)->nullable(); // Peso en kilogramos (si aplica)
            $table->unsignedSmallInteger('order')->default(1); // Orden del ejercicio en la rutina
            $table->timestamps();
            $table->unique(['routine_id', 'exercise_id', 'order'], 'routine_exercise_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_exercises');
    }
};
