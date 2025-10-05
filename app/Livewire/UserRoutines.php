<?php

namespace App\Livewire;

use Livewire\Component;

class UserRoutines extends Component
{
    public $selectedRoutine = null;
    public $showModal = false;
    public $completedExercises = []; // rutina_id => [índices completados]

    public function viewDetails($routineId)
    {
        // 🔹 Datos simulados
        $routines = collect([
            (object) [
                'id' => 1,
                'name' => 'Morning Routine',
                'trainer' => 'John Doe',
                'assigned_date' => '01/10/2025',
                'status' => 'completed',
                'exercises' => [
                    ['name' => 'Push-ups', 'sets' => 3, 'reps' => 15],
                    ['name' => 'Squats', 'sets' => 3, 'reps' => 20],
                    ['name' => 'Plank', 'sets' => 3, 'reps' => '30 sec'],
                ],
            ],
            (object) [
                'id' => 2,
                'name' => 'Cardio Blast',
                'trainer' => 'Mike Johnson',
                'assigned_date' => '03/10/2025',
                'status' => 'active',
                'exercises' => [
                    ['name' => 'Running', 'sets' => 1, 'reps' => '20 min'],
                    ['name' => 'Jump Rope', 'sets' => 3, 'reps' => '1 min'],
                    ['name' => 'Burpees', 'sets' => 3, 'reps' => 10],
                ],
            ],
        ]);

        $this->selectedRoutine = $routines->firstWhere('id', $routineId);
        $this->showModal = true;

        // Inicializamos los ejercicios completados si no existen
        if (!isset($this->completedExercises[$routineId])) {
            $this->completedExercises[$routineId] = [];
        }
    }

    public function toggleExerciseCompletion($routineId, $exerciseIndex)
    {
        if (!isset($this->completedExercises[$routineId])) {
            $this->completedExercises[$routineId] = [];
        }

        if (in_array($exerciseIndex, $this->completedExercises[$routineId])) {
            // Quitar si ya estaba marcado
            $this->completedExercises[$routineId] = array_diff(
                $this->completedExercises[$routineId],
                [$exerciseIndex]
            );
        } else {
            // Marcar como completado
            $this->completedExercises[$routineId][] = $exerciseIndex;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedRoutine = null;
    }

    public function render()
    {
        $routines = collect([
            (object) [
                'id' => 1,
                'name' => 'Morning Routine',
                'trainer' => 'John Doe',
                'assigned_date' => '01/10/2025',
                'status' => 'completed',
            ],
            (object) [
                'id' => 2,
                'name' => 'Cardio Blast',
                'trainer' => 'Mike Johnson',
                'assigned_date' => '03/10/2025',
                'status' => 'active',
            ],
        ]);

        return view('livewire.user-routines', compact('routines'));
    }
}
