<?php

namespace App\Livewire;

use Livewire\Component;

class MemberProgress extends Component
{
    public function render()
    {
        // Datos simulados de progreso corporal
        $progressData = collect([
            ['date' => '2025-06', 'weight' => 78, 'muscle' => 32, 'fat' => 22],
            ['date' => '2025-07', 'weight' => 76.5, 'muscle' => 33, 'fat' => 20.5],
            ['date' => '2025-08', 'weight' => 75.8, 'muscle' => 34, 'fat' => 19.5],
            ['date' => '2025-09', 'weight' => 75.0, 'muscle' => 34.8, 'fat' => 18.8],
            ['date' => '2025-10', 'weight' => 74.4, 'muscle' => 35.1, 'fat' => 18.2],
        ]);

        return view('livewire.member-progress', compact('progressData'));
    }
}
