<x-modal wire:model="showExercisesModal" title="{{ __('Exercises') }}" class="backdrop-blur">
    @if ($selectedRoutine)
        <ul class="space-y-3">
            @foreach ($exercises as $exercise)
                <li class="border-b pb-2 flex justify-between">
                    <span class="font-medium">{{ $exercise->exercise_name }}</span>
                    <span class="text-sm">
                        {{ $exercise->sets }} x {{ $exercise->reps }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif

    <x-slot:actions>
        <x-button label="{{ __('Close') }}" class="btn-secondary" wire:click="$set('showExercisesModal', false)" />
    </x-slot:actions>
</x-modal>
