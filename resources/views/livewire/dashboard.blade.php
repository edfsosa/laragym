<?php

use Livewire\Volt\Component;

new class extends Component {
    // Dashboard component logic
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-stat title="Routines completed" value="24" icon="o-check-circle" color="text-primary" />

        <x-stat title="Exercises completed" value="128" icon="o-check" color="text-primary" />

        <x-stat title="Calories burned" value="5,432" icon="o-fire" color="text-primary" />
    </div>
</div>
