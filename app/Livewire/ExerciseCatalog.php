<?php

namespace App\Livewire;

use Livewire\Component;

class ExerciseCatalog extends Component
{
    public $selectedExercise = null;
    public $showModal = false;

    public function viewDetails($name)
    {
        $allExercises = $this->getAllExercises();
        $this->selectedExercise = $allExercises->firstWhere('name', $name);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->selectedExercise = null;
        $this->showModal = false;
    }

    public function getAllExercises()
    {
        return collect([
            (object) [
                'name' => 'Push-ups',
                'description' => 'Lower your body to the floor and push back up using your arms.',
                'image' => 'https://media2.giphy.com/media/v1.Y2lkPTc5MGI3NjExd2RxcWplZXhyZW1tbHlmZzN0YXU1bTVrN283bWYybGlma29sMmUzciZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/3ohze1qkqPZHMrEuwo/giphy.gif',
                'muscle_group' => 'Chest, Triceps',
            ],
            (object) [
                'name' => 'Squats',
                'description' => 'Bend your knees and lower your body as if sitting.',
                'image' => 'https://media1.giphy.com/media/v1.Y2lkPTc5MGI3NjExanpqa3k2NmEwNnBlNzRiNTdmbnhlOGxnaTcyOWdxa2Q1c3FkMGgxciZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/Y1YTIsIcxgfMk/giphy.gif',
                'muscle_group' => 'Legs, Glutes',
            ],
            (object) [
                'name' => 'Plank',
                'description' => 'Hold a push-up position, keeping your body straight.',
                'image' => 'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExdHNtMzFiMmx6anc2bW85amIwMHQxYzNpYmhwcHI3bmlsNnY4ZWxlYSZlcD12MV9naWZzX3NlYXJjaCZjdD1n/3PywN1RF3eLyVTgzTw/giphy.gif',
                'muscle_group' => 'Core',
            ],
        ]);
    }

    public function render()
    {
        $exercises = $this->getAllExercises();

        return view('livewire.exercise-catalog', compact('exercises'));
    }
}
