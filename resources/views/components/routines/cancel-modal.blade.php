<x-modal title="{{ __('Cancel') }}" wire:model="showCancelRoutineModal" class="backdrop-blur">
    <p>{{ __('Are you sure you want to cancel this routine? All your progress will be lost.') }}</p>

    <x-slot:actions>
        <x-button label="{{ __('Yes, Cancel Routine') }}" class="btn-danger" wire:click="cancelRoutine" icon="o-x-mark"
            spinner />
        <x-button label="{{ __('Close') }}" class="btn-primary" wire:click="$set('showCancelRoutineModal', false)" />
    </x-slot:actions>
</x-modal>
