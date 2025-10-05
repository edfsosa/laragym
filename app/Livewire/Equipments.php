<?php

namespace App\Livewire;

use Livewire\Component;

class Equipments extends Component
{
    public function render()
    {
        $equipments = collect([
            (object) [
                'name' => 'Treadmill',
                'description' => 'A machine for walking or running while staying in one place.',
                'type' => 'Cardio',
                'image' => 'https://tse1.mm.bing.net/th/id/OIP.o1hx0y5NF5u-p-QNdh8eYgHaFw?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3',
                'video' => 'https://example.com/videos/dumbbells.mp4',
                'status' => 'Available',
            ],
            (object) [
                'name' => 'Dumbbells',
                'description' => 'A short bar with a weight at each end, used typically in pairs for exercise or muscle-building.',
                'type' => 'Strength Training',
                'image' => 'https://tse4.mm.bing.net/th/id/OIP.86Hfc1-8P5d5aYaLumFOogHaFY?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3',
                'video' => 'https://example.com/videos/dumbbells.mp4',
                'status' => 'Available',
            ],
            (object) [
                'name' => 'Exercise Bike',
                'description' => 'A stationary bicycle used as exercise equipment.',
                'type' => 'Cardio',
                'image' => 'https://th.bing.com/th/id/R.a8e75740f6575d6d1a0e3712bad912b9?rik=S7CidpP%2fsJQsUQ&pid=ImgRaw&r=0',
                'video' => 'https://example.com/videos/exercise_bike.mp4',
                'status' => 'Maintenance',
            ],
            (object) [
                'name' => 'Kettlebell',
                'description' => 'A cast-iron or cast steel weight used to perform ballistic exercises that combine cardiovascular, strength and flexibility training.',
                'type' => 'Strength Training',
                'image' => 'https://tse2.mm.bing.net/th/id/OIP.jp-xadWgWziWE0_PlBDYHwHaGn?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3',
                'video' => 'https://example.com/videos/kettlebell.mp4',
                'status' => 'Available',
            ],
            (object) [
                'name' => 'Rowing Machine',
                'description' => 'A machine that simulates the action of rowing a boat, used for exercise or training.',
                'type' => 'Cardio',
                'image' => 'https://tse3.mm.bing.net/th/id/OIP.7X8tBgK8hoQhbN_F3QYMUAHaHa?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3',
                'video' => 'https://example.com/videos/rowing_machine.mp4',
                'status' => 'Out of Order',
            ],
        ]);

        return view('livewire.equipments', compact('equipments'));
    }
}
