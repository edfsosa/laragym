<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;

class Trainers extends Component
{
    public bool $showModal = false;
    public ?object $selectedTrainer = null;

    /**
     * Mostrar los detalles del entrenador seleccionado
     */
    public function viewTrainer(int $id): void
    {
        $this->selectedTrainer = $this->getMockedTrainers()
            ->firstWhere('id', $id);

        $this->showModal = (bool) $this->selectedTrainer;
    }

    /**
     * Cerrar el modal
     */
    public function closeModal(): void
    {
        $this->selectedTrainer = null;
        $this->showModal = false;
    }

    /**
     * Obtener entrenadores (simulados por ahora)
     */
    private function getMockedTrainers(): Collection
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Carlos Gómez',
                'specialty' => 'Entrenamiento Funcional',
                'rating' => 4.8,
                'photo' => 'https://randomuser.me/api/portraits/men/11.jpg',
                'bio' => 'Apasionado del fitness con más de 10 años de experiencia en entrenamiento funcional, fuerza y movilidad.',
                'routines' => ['Full Body Funcional', 'Movilidad Articular'],
            ],
            (object) [
                'id' => 2,
                'name' => 'María López',
                'specialty' => 'Yoga y Flexibilidad',
                'rating' => 4.9,
                'photo' => 'https://randomuser.me/api/portraits/women/32.jpg',
                'bio' => 'Instructora certificada en Yoga y Pilates. Promueve el equilibrio entre mente y cuerpo mediante rutinas adaptadas.',
                'routines' => ['Yoga Matutino', 'Stretch Flow', 'Respiración y Mindfulness'],
            ],
            (object) [
                'id' => 3,
                'name' => 'Diego Fernández',
                'specialty' => 'Fuerza e Hipertrofia',
                'rating' => 4.7,
                'photo' => 'https://randomuser.me/api/portraits/men/21.jpg',
                'bio' => 'Entrenador personal especializado en musculación y fuerza. Ha ayudado a más de 200 clientes a lograr sus metas físicas.',
                'routines' => ['Hipertrofia Avanzada', 'Push Pull Legs', 'Split 5 Días'],
            ],
        ]);
    }

    /**
     * Renderizar la vista del componente
     */
    public function render()
    {
        return view('livewire.trainers', [
            'trainers' => $this->getMockedTrainers(),
        ]);
    }
}
