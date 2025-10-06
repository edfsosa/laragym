<?php

namespace App\Livewire;

use Livewire\Component;

class Equipments extends Component
{
    public $equipments = [];
    public $selectedEquipment = null;
    public $showModal = false;

    public function mount()
    {
        $this->equipments = $this->getMockedEquipments();
    }

    public function viewEquipment($id)
    {
        $this->selectedEquipment = collect($this->equipments)->firstWhere('id', $id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->selectedEquipment = null;
        $this->showModal = false;
    }

    private function getMockedEquipments()
    {
        return [
            (object) [
                'id' => 1,
                'name' => 'Treadmill',
                'description' => 'A machine for walking or running while staying in one place.',
                'type' => 'Cardio',
                'image' => 'https://tse1.mm.bing.net/th/id/OIP.o1hx0y5NF5u-p-QNdh8eYgHaFw?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3',
                'video' => 'https://www.youtube.com/watch?v=XmR1kSPaEEA',
                'status' => 'Available',
            ],
            (object) [
                'id' => 2,
                'name' => 'Dumbbells',
                'description' => 'A short bar with a weight at each end, used typically in pairs for exercise or muscle-building.',
                'type' => 'Strength Training',
                'image' => 'https://tse4.mm.bing.net/th/id/OIP.86Hfc1-8P5d5aYaLumFOogHaFY?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3',
                'video' => 'https://www.youtube.com/watch?v=U0bhE67HuDY',
                'status' => 'Available',
            ],
            (object) [
                'id' => 3,
                'name' => 'Exercise Bike',
                'description' => 'A stationary bicycle used as exercise equipment.',
                'type' => 'Cardio',
                'image' => 'https://th.bing.com/th/id/R.a8e75740f6575d6d1a0e3712bad912b9?rik=S7CidpP%2fsJQsUQ&pid=ImgRaw&r=0',
                'video' => 'https://www.youtube.com/watch?v=HVz5XyjHorc',
                'status' => 'Maintenance',
            ],
            (object) [
                'id' => 4,
                'name' => 'Kettlebell',
                'description' => 'Used for ballistic exercises that combine cardiovascular, strength and flexibility training.',
                'type' => 'Strength Training',
                'image' => 'https://tse2.mm.bing.net/th/id/OIP.jp-xadWgWziWE0_PlBDYHwHaGn?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3',
                'video' => 'https://www.youtube.com/watch?v=8QZ9cLGn2uQ',
                'status' => 'Available',
            ],
            (object) [
                'id' => 5,
                'name' => 'Rowing Machine',
                'description' => 'Simulates rowing a boat, used for cardio training.',
                'type' => 'Cardio',
                'image' => 'https://tse3.mm.bing.net/th/id/OIP.7X8tBgK8hoQhbN_F3QYMUAHaHa?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3',
                'video' => 'https://www.youtube.com/watch?v=9RaQeLMaABM',
                'status' => 'Out of Order',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.equipments');
    }
}
