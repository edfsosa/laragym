<x-card title="{{ $membership->name }}" shadow>
    <div>
        <div class="mb-4">
            <span class="text-sm">
                {{ $membership->description }}
            </span>
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium">
                    {{ __('Price') }}</span>
                <p>
                    {{ $membership->price_formatted }}
                </p>
            </div>
            <div>
                <span class="font-medium">
                    {{ __('Duration') }}</span>
                <p>
                    {{ $membership->duration_days_formatted }}
                </p>
            </div>
        </div>
    </div>

    <x-slot:actions separator>
        <x-button label="{{ __('Join Now') }}" wire:click="joinMembership({{ $membership->id }})" icon="o-check"
            class="btn-primary" spinner />
    </x-slot:actions>
</x-card>
