<?php

namespace App\Livewire;

use Livewire\Component;

class MemberTrainers extends Component
{
    public $showModal = false;
    public $selectedTrainer = null;

    public function viewTrainer($id)
    {
        $trainers = $this->getMockedTrainers();
        $this->selectedTrainer = $trainers->firstWhere('id', $id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedTrainer = null;
    }

    private function getMockedTrainers()
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Carlos Gómez',
                'specialty' => 'Entrenamiento Funcional',
                'rating' => 4.8,
                'photo' => 'https://randomuser.me/api/portraits/men/11.jpg',
                'bio' => 'Apasionado del fitness con más de 10 años de experiencia en entrenamiento funcional, fuerza y movilidad.',
                'routines' => ['Power Start', 'Full Body Burn', 'Cardio Blast'],
            ],
            (object) [
                'id' => 2,
                'name' => 'María López',
                'specialty' => 'Yoga y Flexibilidad',
                'rating' => 4.9,
                'photo' => 'https://randomuser.me/api/portraits/women/32.jpg',
                'bio' => 'Instructora certificada en Yoga y Pilates. Promueve el equilibrio entre mente y cuerpo mediante rutinas adaptadas.',
                'routines' => ['Morning Flow', 'Zen Stretch', 'Mindful Balance'],
            ],
            (object) [
                'id' => 3,
                'name' => 'Diego Fernández',
                'specialty' => 'Fuerza e Hipertrofia',
                'rating' => 4.7,
                'photo' => 'https://randomuser.me/api/portraits/men/21.jpg',
                'bio' => 'Entrenador personal especializado en musculación y fuerza. Ha ayudado a más de 200 clientes a lograr sus metas físicas.',
                'routines' => ['Muscle Max', 'Core Builder', 'Strength 360'],
            ],
        ]);
    }

    public function render()
    {
        $trainers = $this->getMockedTrainers();
        return view('livewire.member-trainers', compact('trainers'));
    }
}
