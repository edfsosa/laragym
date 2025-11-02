<?php

use App\Models\UserRoutine;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Routines')] 
class extends Component {
    use Toast;

    public function routines(): Collection
    {
        return UserRoutine::query()
            ->with(['user', 'routine', 'assignedBy'])
            ->withCount('exerciseLogs')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function assignedRoutines(): Collection
    {
        return $this->routines()->where('status', 'assigned')->sortByDesc('assigned_at');
    }

    public function completedRoutines(): Collection
    {
        return $this->routines()->where('status', 'completed')->sortByDesc('completed_at')->take(5);
    }

    public function with(): array
    {
        return [
            'routines' => $this->routines(),
            'assignedRoutines' => $this->assignedRoutines(),
            'completedRoutines' => $this->completedRoutines(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Routines') }}" separator progress-indicator />

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => '/dashboard',
            ],
            [
                'label' => __('Routines'),
                'link' => '/routines',
            ],
        ];
    @endphp
    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    @if ($assignedRoutines->isEmpty() && $completedRoutines->isEmpty())
        <x-alert title="{{ __('No Routines Found') }}"
            description="{{ __('You have no assigned or completed routines at the moment.') }}" icon="o-check-circle"
            class="alert-info mt-8" />
    @endif

    @if ($assignedRoutines->isNotEmpty())
        <x-header title="{{ __('Assigned Routines') }}" size="text-lg" class="mt-8" />
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($assignedRoutines as $assignedRoutine)
                <x-card title="{{ $assignedRoutine->routine_name }}" shadow>
                    <div class="flex flex-col gap-2">
                        <span class="text-sm text-gray-500">
                            {{ __('Assigned by') }} {{ $assignedRoutine->assignedBy->name }}
                            {{ $assignedRoutine->assigned_at_formatted }}
                        </span>
                        <x-progress value="{{ $assignedRoutine->exercise_logs_completed_count }}"
                            max="{{ $assignedRoutine->exercise_logs_count }}" class="mt-2" />
                        <span class="text-sm text-gray-500">
                            {{ $assignedRoutine->exercise_logs_completed_count }}/{{ $assignedRoutine->exercise_logs_count }}
                            {{ __('exercises completed') }} ({{ $assignedRoutine->progress_percentage }}%)
                        </span>
                    </div>
                    <x-slot:menu>
                        <x-badge value="{{ $assignedRoutine->routine_level_translated }}"
                            class="{{ $assignedRoutine->routine_level_badge }}" />
                    </x-slot:menu>
                    <x-slot:actions separator>
                        <x-button label="{{ __('View') }}" icon="o-eye" class="btn-primary"
                            link="{{ route('routines.show', $assignedRoutine) }}" spinner />
                    </x-slot:actions>
                </x-card>
            @endforeach
        </div>
    @endif

    @if ($completedRoutines->isNotEmpty())
        <x-header title="{{ __('Recently Completed Routines') }}" size="text-lg" class="mt-8" />
        <x-card shadow>
            @foreach ($completedRoutines as $completedRoutine)
                <x-list-item :item="$completedRoutine">
                    <x-slot:actions>
                        <x-badge value="{{ $completedRoutine->routine_level_translated }}"
                            class="{{ $completedRoutine->routine_level_badge }}" />
                    </x-slot:actions>
                    <x-slot:value>
                        {{ $completedRoutine->routine_name }}
                    </x-slot:value>
                    <x-slot:sub-value>
                        <span class="text-sm text-gray-500">
                            {{ $completedRoutine->completed_at_formatted }}
                        </span>
                    </x-slot:sub-value>
                </x-list-item>
            @endforeach
            <x-slot:actions separator>
                <x-button link="{{ route('routines.completed') }}"
                class="btn-primary mt-4" 
                label="{{ __('View All') }}" 
                icon="o-arrow-right" />
            </x-slot:actions>
        </x-card>
    @endif
</div>
