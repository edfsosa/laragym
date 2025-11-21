<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($routines as $routine)
        <x-card title="{{ $routine->name }}" shadow>
            <div>
                <div class="mb-4">
                    <span class="text-sm">
                        {{ $routine->short_description }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium">
                            {{ __('Level') }}</span>
                        <p>
                            {{ $routine->level_translated }}
                        </p>
                    </div>
                    <div>
                        <span class="font-medium">
                            {{ __('Duration') }}</span>
                        <p>
                            {{ $routine->duration_minutes }} {{ __('minutes') }}
                        </p>
                    </div>
                    <div>
                        <span class="font-medium">
                            {{ __('Type') }}</span>
                        <p>
                            {{ $routine->type_translated }}
                        </p>
                    </div>
                    <div>
                        <span class="font-medium">
                            {{ __('Muscle group') }}</span>
                        <p>
                            {{ $routine->muscle_group_translated }}
                        </p>
                    </div>
                </div>
            </div>

            <x-slot:actions separator>
                <x-button label="{{ __('Assign To Me') }}" icon="o-check" class="btn-primary"
                    wire:click="assignRoutine({{ $routine->id }})" spinner />
                <x-button label="{{ __('View Exercises') }}" icon="o-list-bullet" class="btn-secondary"
                    wire:click="viewExercises({{ $routine->id }})" spinner />
            </x-slot:actions>
        </x-card>
    @empty
        {{-- NO RESULTS --}}
        <x-alert title="{{ __('No routines found') }}"
            description="{{ __('Try adjusting your search or filter to find what you are looking for.') }}"
            icon="o-exclamation-triangle" class="col-span-full">
            <x-slot:actions>
                <x-button label="{{ __('Clear Search') }}" wire:click="clear" icon="o-x-mark" class="btn-primary"
                    spinner />
            </x-slot:actions>
        </x-alert>
    @endforelse
</div>
