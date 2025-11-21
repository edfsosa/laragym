<x-card shadow>
    {{--  TITLE --}}
    <x-slot:title>
        {{ $routine->routine_name }}
    </x-slot:title>

    <x-slot:menu>
        <x-badge value="{{ $routine->routine_level_translated }}" class="{{ $routine->routine_level_badge }}" />
    </x-slot:menu>

    {{-- CONTENT  --}}
    <div>
        <div class="mb-4">
            <span class="text-sm text-gray-500">
                {{ __('Assigned by') }} {{ $routine->assignedBy->name }}
                {{ $routine->assigned_at_formatted }}
            </span>
        </div>
        <div class="mb-6">
            <x-progress value="{{ $routine->exercise_logs_completed_count }}" max="{{ $routine->exercise_logs_count }}"
                class="mb-2" />
            <div class="text-sm text-gray-500 mb-4">
                {{ $routine->exercise_logs_completed_count }}/{{ $routine->exercise_logs_count }}
                {{ __('exercises completed') }} ({{ $routine->progress_percentage }}%)
            </div>
        </div>
        <div>
            <p class="mb-4">
                {{ __('Here are the exercises assigned to this routine. Mark them as completed as you finish them.') }}
            </p>
            @forelse ($logs as $log)
                <x-list-item :item="$log">
                    <x-slot:avatar>
                        <x-badge value="{{ $log->routineExercise->order }}" />
                    </x-slot:avatar>
                    <x-slot:value>
                        {{ $log->routineExercise->exercise_name }}
                    </x-slot:value>
                    <x-slot:sub-value>
                        <div>
                            {{ $log->routineExercise->sets }}x{{ $log->routineExercise->reps }}
                        </div>
                    </x-slot:sub-value>
                    <x-slot:actions>
                        @if ($log->status == 'pending')
                            <x-button icon="o-check" class="btn-sm" wire:click="complete({{ $log->id }})"
                                spinner />
                        @elseif ($log->status == 'completed')
                            <x-badge value="{{ __('Completed') }}" class="badge-success" />
                        @endif
                    </x-slot:actions>
                </x-list-item>
            @empty
                <p>{{ __('No exercises assigned to this routine.') }}</p>
            @endforelse
        </div>
    </div>
</x-card>
