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
                class="mb-2 h-4 rounded-lg" />
            <div class="text-sm text-gray-500 mb-4">
                {{ $routine->exercise_logs_completed_count }}/{{ $routine->exercise_logs_count }}
                {{ __('exercises completed') }} ({{ $routine->progress_percentage }}%)
            </div>
        </div>
        <div>
            <div>
                <h3 class="text-lg font-semibold mb-2">{{ __('Exercises') }}</h3>
            </div>
            @forelse ($logs as $log)
                <x-list-item :item="$log"
                    class="hover:bg-base-200 transition-colors duration-200 {{ $log->status === 'completed' ? 'opacity-75' : '' }}">
                    {{-- Avatar: Exercise Order Number --}}
                    <x-slot:avatar>
                        <div class="relative">
                            <x-badge value="{{ $log->routineExercise->order }}"
                                class="{{ $log->status === 'completed' ? 'badge-success' : 'badge-primary' }} badge-lg font-bold" />
                            @if ($log->status === 'completed')
                                <x-icon name="o-check-circle"
                                    class="w-4 h-4 text-success absolute -top-1 -right-1 bg-white dark:bg-base-100 rounded-full" />
                            @endif
                        </div>
                    </x-slot:avatar>

                    {{-- Exercise Name --}}
                    <x-slot:value>
                        <span
                            class="{{ $log->status === 'completed' ? 'line-through text-gray-500 dark:text-gray-400' : 'font-semibold text-gray-900 dark:text-gray-100' }}">
                            {{ $log->routineExercise->exercise_name }}
                        </span>
                    </x-slot:value>

                    {{-- Sets x Reps + Additional Info --}}
                    <x-slot:sub-value>
                        {{-- Responsive Layout: Stacked on mobile, Row on desktop --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-1">
                            {{-- Sets --}}
                            <div class="flex items-center gap-1">
                                <x-icon name="o-arrow-path" class="w-4 h-4 text-gray-400" />
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $log->routineExercise->sets }} {{ __('sets') }}
                                </span>
                            </div>

                            {{-- Separator (hidden on mobile) --}}
                            <span class="hidden sm:inline text-gray-400">•</span>

                            {{-- Reps --}}
                            <div class="flex items-center gap-1">
                                <x-icon name="o-hashtag" class="w-4 h-4 text-gray-400" />
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $log->routineExercise->reps }} {{ __('reps') }}
                                </span>
                            </div>

                            {{-- Completed Time --}}
                            @if ($log->status === 'completed' && $log->completed_at)
                                {{-- Separator (hidden on mobile) --}}
                                <span class="hidden sm:inline text-gray-400">•</span>

                                <div class="flex items-center gap-1">
                                    <x-icon name="o-clock" class="w-4 h-4 text-success" />
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $log->completed_at->diffForHumans() }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </x-slot:sub-value>

                    {{-- Actions --}}
                    <x-slot:actions>
                        @if ($log->status === 'pending')
                            <div class="flex items-center gap-2">
                                {{-- Skip Button --}}
                                <x-button icon="o-forward" class="btn-warning btn-sm"
                                    wire:click="skip({{ $log->id }})" tooltip="{{ __('Skip this exercise') }}"
                                    tooltip-left spinner wire:loading.attr="disabled"
                                    wire:target="skip({{ $log->id }})">
                                    <span class="hidden sm:inline">{{ __('Skip') }}</span>
                                </x-button>

                                {{-- Complete Button --}}
                                <x-button icon="o-check-circle" class="btn-success btn-sm"
                                    wire:click="complete({{ $log->id }})" tooltip="{{ __('Mark as completed') }}"
                                    tooltip-left spinner wire:loading.attr="disabled"
                                    wire:target="complete({{ $log->id }})">
                                    <span class="hidden sm:inline">{{ __('Complete') }}</span>
                                </x-button>
                            </div>
                        @elseif($log->status === 'completed')
                            <div class="flex items-center gap-2">
                                {{-- Optional: Undo Button --}}
                                <x-button icon="o-arrow-uturn-left" class="btn-ghost btn-sm"
                                    wire:click="undoComplete({{ $log->id }})" tooltip="{{ __('Undo') }}"
                                    tooltip-left spinner />
                            </div>
                        @elseif($log->status === 'skipped')
                            <x-badge value="{{ __('Skipped') }}" class="badge-warning" />
                        @endif
                    </x-slot:actions>
                </x-list-item>
            @empty
                <x-alert title="{{ __('No Exercises Found') }}"
                    description="{{ __('There are no exercises assigned to this routine.') }}"
                    icon="o-information-circle" />
            @endforelse
        </div>
    </div>

    <x-slot:actions separator>
        <x-button label="{{ __('Cancel') }}" icon="o-x-mark" class="btn-danger"
            wire:click="confirmCancelRoutine({{ $routine->id }})" spinner />
    </x-slot:actions>
</x-card>
