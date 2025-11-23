<?php

use App\Models\UserRoutine;
use App\Models\RoutineExercise;
use App\Models\UserRoutineExerciseLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Routine Details')] class extends Component {
    use Toast;

    public bool $showRoutineCompletedModal = false;
    public bool $showCancelRoutineModal = false;

    public UserRoutine $routine;

    /**
     * Ejercicios de seguimiento asociados a la rutina.
     */
    public function exercises(): Collection
    {
        return RoutineExercise::query()->when($this->routine->id, fn(Builder $q) => $q->where('routine_id', $this->routine->id))->get();
    }

    /**
     * Logs de ejercicios del usuario para la rutina.
     */
    public function logs(): Collection
    {
        return UserRoutineExerciseLog::query()->when($this->routine->id, fn(Builder $q) => $q->where('user_routine_id', $this->routine->id))->get();
    }

    /**
     * Marca un ejercicio como completado.
     */
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

    /**
     * Actualiza el estado de la rutina si todos los ejercicios están completados.
     */
    private function updateRoutineStatusIfNeeded(): void
    {
        $totalExercises = UserRoutineExerciseLog::where('user_routine_id', $this->routine->id)->count();
        $completedExercises = UserRoutineExerciseLog::where('user_routine_id', $this->routine->id)->where('status', 'completed')->count();

        if ($totalExercises > 0 && $totalExercises === $completedExercises) {
            $this->routine->status = 'completed';
            $this->routine->completed_at = now();
            $this->routine->save();
            $this->routine = $this->routine->fresh();
            $this->showRoutineCompletedModal = true;
        }
    }

    public function confirmCancelRoutine(int $routineId): void
    {
        $routine = UserRoutine::where('id', $routineId)
            ->where('user_id', auth()->id())
            ->where('status', 'assigned')
            ->first();

        if (!$routine) {
            $this->error(__('Routine not found or cannot be canceled.'));
            return;
        }

        $this->routine = $routine;
        $this->showCancelRoutineModal = true;
    }

    public function cancelRoutine(): void
    {
        if (!$this->routine) {
            $this->error(__('No routine selected for cancellation.'));
            return;
        }

        $this->routine->status = 'cancelled';
        $this->routine->save();

        $this->showCancelRoutineModal = false;

        $this->success(__('Routine canceled successfully.'));
        $this->redirect('/routines');
    }

    /**
     * Datos para la vista.
     */
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
    <x-header title="{{ __('Routine details') }}" separator />

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
    {{--  BREADCRUMBS  --}}
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    {{-- ACTIONS --}}
    <div class="flex items-center justify-start mb-6 space-x-2">
        <x-routines.go-back-button />
        @if ($routine->status === 'assigned')
            <x-button label="{{ __('Cancel') }}" icon="o-x-mark" class="btn-danger"
                wire:click="confirmCancelRoutine({{ $routine->id }})" spinner />
        @endif
    </div>

    {{--  CARD  --}}
    @if ($routine->status === 'assigned')
        <x-routines.details-card :routine="$routine" :logs="$logs" wire:loading.remove />
    @elseif ($routine->status === 'completed')
        <x-card shadow>
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">{{ __('Routine Completed') }}</h2>
                <p>{{ __('You have already completed this routine') }} {{ $routine->completed_at_formatted }}.</p>
            </div>
        </x-card>
    @elseif ($routine->status === 'cancelled')
        <x-card shadow>
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">{{ __('Routine Cancelled') }}</h2>
                <p>{{ __('This routine was cancelled on') }} {{ $routine->updated_at->format('F j, Y') }}.</p>
            </div>
        </x-card>
    @endif
    {{--  MODAL ROUTINE COMPLETED  --}}
    <x-routines.completed-modal />

    {{--  MODAL CANCEL ROUTINE  --}}
    <x-routines.cancel-modal />
</div>
