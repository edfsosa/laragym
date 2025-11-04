<?php

use App\Models\UserRoutine;
use App\Models\RoutineExercise;
use App\Models\UserRoutineExerciseLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Routine Details')] 
class extends Component {
    use Toast;

    public UserRoutine $routine;

    public function exercises(): Collection
    {
        return RoutineExercise::query()->when($this->routine->id, fn(Builder $q) => $q->where('routine_id', $this->routine->id))->get();
    }

    public function logs(): Collection
    {
        return UserRoutineExerciseLog::query()->when($this->routine->id, fn(Builder $q) => $q->where('user_routine_id', $this->routine->id))->get();
    }

    // logica de complete
    public function complete(int $logId): void
    {
        $log = UserRoutineExerciseLog::find($logId);

        if (!$log) {
            $this->error(__('Exercise log not found.'));
            return;
        }

        if ($log->status === 'completed') {
            $this->error(__('This exercise is already marked as completed.'));
            return;
        }

        if ($log->status === 'skipped') {
            $this->error(__('This exercise has been skipped and cannot be marked as completed.'));
            return;
        }

        if ($log->status === 'pending') {
            $log->status = 'completed';
            $log->completed_at = now();
            $log->save();

            $this->routine = $this->routine->fresh();
            $this->success(__('Exercise marked as completed.'));
            $this->updateRoutineStatusIfNeeded();
            return;
        }
    }

    private function updateRoutineStatusIfNeeded(): void
    {
        $totalExercises = UserRoutineExerciseLog::where('user_routine_id', $this->routine->id)->count();
        $completedExercises = UserRoutineExerciseLog::where('user_routine_id', $this->routine->id)
            ->where('status', 'completed')
            ->count();

        if ($totalExercises > 0 && $totalExercises === $completedExercises) {
            $this->routine->status = 'completed';
            $this->routine->completed_at = now();
            $this->routine->save();
            $this->routine = $this->routine->fresh();
            $this->success(__('Congratulations! You have completed the routine.'));
        }
    }

    public function with(): array
    {
        return [
            'exercises' => $this->exercises(),
            'logs' => $this->logs(),
        ];
    }
}; ?>

<div>
    {{--  HEADER  --}}
    <x-header :title="$routine->routine_name" separator />

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
                'label' => $routine->routine_name,
            ],
        ];
    @endphp

    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    {{--  MEMBERSHIP BODY  --}}
    <x-card separator shadow>
        {{--  TITLE --}}
        <x-slot:title>
            {{ $routine->routine_description }}
        </x-slot:title>

        <x-slot:menu>
            <x-badge :value="$routine->status_translated" class="badge-primary" />
        </x-slot:menu>

        <div class="space-y-2">
            <p><strong>{{ __('Assigned by') }}:</strong> {{ $routine->assigned_by_name }}
                {{ $routine->assigned_at_formatted }}</p>
            <div>
                @forelse ($logs as $log)
                    <x-list-item :item="$log">
                        <x-slot:avatar>
                            <x-badge value="{{ $log->routineExercise->order }}" class="badge-primary" />
                        </x-slot:avatar>
                        <x-slot:value>
                            {{ $log->routineExercise->exercise_name }}
                        </x-slot:value>
                        <x-slot:sub-value>
                            {{ $log->routineExercise->exercise_description }}
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
</div>
