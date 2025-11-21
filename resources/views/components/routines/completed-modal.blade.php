<x-modal title="{{ __('Routine Completed') }}" wire:model="showRoutineCompletedModal" class="backdrop-blur">
    <p>{{ __('Congratulations! You have completed all exercises in this routine.') }}</p>

    <x-slot:actions>
        <x-button label="{{ __('Close') }}" class="btn-primary" wire:click="$set('showRoutineCompletedModal', false)" />
    </x-slot:actions>
</x-modal>
