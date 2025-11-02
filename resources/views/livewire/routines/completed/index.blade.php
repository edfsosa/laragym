<?php

use App\Models\UserRoutine;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Completed Routines')] class extends Component {
    use Toast;

    public function completedRoutines(): Collection
    {
        return UserRoutine::query()
            ->with(['user', 'routine', 'assignedBy'])
            ->withCount('exerciseLogs')
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->orderByDesc('completed_at')
            ->get();
    }

    public function with(): array
    {
        return [
            'completedRoutines' => $this->completedRoutines(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Routines Completed') }}" separator progress-indicator />

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
            [
                'label' => __('Completed'),
                'link' => '/routines/completed',
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- COMPLETED ROUTINES LIST -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($completedRoutines as $completedRoutine)
            <x-card title="{{ $completedRoutine->routine_name }}" shadow>
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">
                        {{ __('Assigned by') }} {{ $completedRoutine->assigned_by_name }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ __('Completed') }} {{ $completedRoutine->completed_at_formatted }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $completedRoutine->exercise_logs_completed_count }}/{{ $completedRoutine->exercise_logs_count }}
                        {{ __('exercises completed') }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ __('Calories Burned:') }}
                    </span>
                </div>
                <x-slot:menu>
                    <x-badge value="{{ $completedRoutine->routine_level_translated }}"
                        class="{{ $completedRoutine->routine_level_badge }}" />
                </x-slot:menu>
                <x-slot:actions separator>
                    <div class="flex items-center gap-2">
                        <x-rating wire:model="ranking0" />
                        <x-button label="{{ __('View') }}" icon="o-eye" class="btn-primary"
                            link="{{ route('routines.completed.show', $completedRoutine) }}" spinner />
                    </div>
                </x-slot:actions>
            </x-card>
        @empty <p class="col-span-full text-center text-gray-500">
                {{ __('No completed routines found.') }}
            </p>
        @endforelse
    </div>
</div>
