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

    // Cache para evitar múltiples consultas
    private ?Collection $cachedExercises = null;
    private ?Collection $cachedLogs = null;

    /**
     * Ejercicios de seguimiento asociados a la rutina.
     */
    public function exercises(): Collection
    {
        if ($this->cachedExercises === null) {
            $this->cachedExercises = RoutineExercise::query()->where('routine_id', $this->routine->id)->get();
        }

        return $this->cachedExercises;
    }

    /**
     * Logs de ejercicios del usuario para la rutina.
     */
    public function logs(): Collection
    {
        if ($this->cachedLogs === null) {
            $this->cachedLogs = UserRoutineExerciseLog::query()->where('user_routine_id', $this->routine->id)->get();
        }

        return $this->cachedLogs;
    }

    /**
     * Marca un ejercicio como completado.
     */
    public function complete(int $logId): void
    {
        $this->updateExerciseStatus($logId, 'completed', __('Exercise marked as completed.'));
    }

    /**
     * Marca un ejercicio como saltado.
     */
    public function skip(int $logId): void
    {
        $this->updateExerciseStatus($logId, 'skipped', __('Exercise marked as skipped.'));
    }

    /**
     * Actualiza el estado de un ejercicio (completado o saltado).
     */
    private function updateExerciseStatus(int $logId, string $newStatus, string $successMessage): void
    {
        $log = UserRoutineExerciseLog::find($logId);

        if (!$log) {
            $this->error(__('Exercise log not found.'));
            return;
        }

        // Validar transiciones de estado
        $validationError = $this->validateStatusTransition($log, $newStatus);
        if ($validationError) {
            $this->error($validationError);
            return;
        }

        // Actualizar estado
        $log->status = $newStatus;
        $log->completed_at = $newStatus === 'completed' ? now() : null;
        $log->save();

        // Limpiar cache y recargar
        $this->clearCache();
        $this->routine->refresh();

        $this->success($successMessage);
        $this->updateRoutineStatusIfNeeded();
    }

    /**
     * Valida si la transición de estado es válida.
     */
    private function validateStatusTransition(UserRoutineExerciseLog $log, string $newStatus): ?string
    {
        // Si ya está en el estado objetivo
        if ($log->status === $newStatus) {
            return $newStatus === 'completed' ? __('This exercise is already marked as completed.') : __('This exercise is already marked as skipped.');
        }

        // Validar transiciones inválidas
        if ($newStatus === 'completed' && $log->status === 'skipped') {
            return __('This exercise has been skipped and cannot be marked as completed.');
        }

        if ($newStatus === 'skipped' && $log->status === 'completed') {
            return __('This exercise has been completed and cannot be marked as skipped.');
        }

        return null;
    }

    /**
     * Actualiza el estado de la rutina si todos los ejercicios están completados o saltados.
     */
    private function updateRoutineStatusIfNeeded(): void
    {
        // Usar una sola consulta con agregación
        $stats = UserRoutineExerciseLog::where('user_routine_id', $this->routine->id)
            ->selectRaw(
                '
                COUNT(*) as total,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = "skipped" THEN 1 ELSE 0 END) as skipped,
                SUM(CASE WHEN status IN ("completed", "skipped") THEN 1 ELSE 0 END) as finished
            ',
            )
            ->first();

        // Si todos los ejercicios tienen un estado final (completed o skipped)
        if ($stats->total > 0 && $stats->total == $stats->finished) {
            $this->routine->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $this->routine->refresh();
            $this->showRoutineCompletedModal = true;
        }
    }

    /**
     * Obtiene las estadísticas de la rutina para mostrar en el modal.
     */
    public function getRoutineStats(): array
    {
        $stats = UserRoutineExerciseLog::where('user_routine_id', $this->routine->id)
            ->selectRaw(
                '
                COUNT(*) as total,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = "skipped" THEN 1 ELSE 0 END) as skipped,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending
            ',
            )
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'completed' => $stats->completed ?? 0,
            'skipped' => $stats->skipped ?? 0,
            'pending' => $stats->pending ?? 0,
            'completion_percentage' => $stats->total > 0 ? round(($stats->completed / $stats->total) * 100, 1) : 0,
        ];
    }

    /**
     * Confirma la cancelación de una rutina.
     */
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

    /**
     * Cancela la rutina actual.
     */
    public function cancelRoutine(): void
    {
        if (!$this->routine) {
            $this->error(__('No routine selected for cancellation.'));
            return;
        }

        $this->routine->update(['status' => 'cancelled']);
        $this->showCancelRoutineModal = false;

        $this->success(__('Routine canceled successfully.'));
        $this->redirect('/routines');
    }

    /**
     * Cierra el modal de rutina completada y redirige a la lista de rutinas.
     */
    public function closeCompletedModal(): void
    {
        $this->showRoutineCompletedModal = false;
        $this->redirect('/routines');
    }

    /**
     * Limpia el cache de ejercicios y logs.
     */
    private function clearCache(): void
    {
        $this->cachedExercises = null;
        $this->cachedLogs = null;
    }

    /**
     * Datos para la vista.
     */
    public function with(): array
    {
        return [
            'exercises' => $this->exercises(),
            'logs' => $this->logs(),
            'stats' => $this->getRoutineStats(),
        ];
    }
};
?>

<div>
    {{--  HEADER  --}}
    <x-header title="{{ __('Routine Details') }}" separator>
        <x-slot:actions>
            <x-button link="/routines" label="{{ __('Back to Routines') }}" icon="o-arrow-left" class="btn-ghost"/>
        </x-slot:actions>
    </x-header>

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => '/dashboard',
                'icon' => 'o-home',
            ],
            [
                'label' => __('Routines'),
                'link' => '/routines',
                'icon' => 'o-clipboard-document-list',
            ],
            [
                'label' => $routine->routine_name,
                'icon' => 'o-list-bullet',
            ],
        ];
    @endphp
    {{--  BREADCRUMBS  --}}
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    {{--  CARD  --}}
    <x-routines.details-card :routine="$routine" :logs="$logs" wire:loading.remove />
</div>
