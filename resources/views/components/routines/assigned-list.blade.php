<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($routines as $routine)
        <x-card title="{{ $routine->routine_name }}" shadow>
            <div>
                <div class="mb-4">
                    <span class="text-sm text-gray-500">
                        {{ __('Assigned by') }} {{ $routine->assignedBy->name }}
                        {{ $routine->assigned_at_formatted }}
                    </span>
                </div>
                <div class="mb-6">
                    <x-progress value="{{ $routine->exercise_logs_completed_count }}"
                        max="{{ $routine->exercise_logs_count }}" class="mb-2" />
                    <div class="text-sm text-gray-500 mb-4">
                        {{ $routine->exercise_logs_completed_count }}/{{ $routine->exercise_logs_count }}
                        {{ __('exercises completed') }} ({{ $routine->progress_percentage }}%)
                    </div>
                </div>
            </div>

            <x-slot:menu>
                <x-badge value="{{ $routine->routine_level_translated }}"
                    class="{{ $routine->routine_level_badge }}" />
            </x-slot:menu>

            <x-slot:actions separator>
                <x-button label="{{ $routine->progress_percentage > 0 ? __('Continue') : __('Start') }}" icon="o-play"
                    class="btn-primary" link="{{ route('routines.show', $routine) }}" spinner />
                <x-button label="{{ __('Cancel') }}" icon="o-x-mark" class="btn-danger"
                    wire:click="confirmCancelRoutine({{ $routine->id }})" spinner />
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
