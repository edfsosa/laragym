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
            <x-button link="/routines" label="{{ __('Back to Routines') }}" icon="o-arrow-left" class="btn-ghost" />
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
    <x-card shadow>
        {{-- TITLE --}}
        <x-slot:title>
            <div class="flex items-center gap-3">
                <x-icon name="o-fire" class="w-6 h-6 text-primary" />
                <span>{{ $routine->routine_name }}</span>
            </div>
        </x-slot:title>

        <x-slot:menu>
            <x-badge value="{{ $routine->routine_level_translated }}" class="{{ $routine->routine_level_badge }}" />
        </x-slot:menu>

        {{-- CONTENT --}}
        <div class="space-y-6">
            {{-- Header Info --}}
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <x-icon name="o-user-circle" class="w-4 h-4" />
                <span>
                    {{ __('Assigned by') }} <span
                        class="font-medium text-gray-900 dark:text-gray-100">{{ $routine->assignedBy->name }}</span>
                </span>
                <span class="text-gray-400">•</span>
                <span>{{ $routine->assigned_at_formatted }}</span>
            </div>

            {{-- Progress Section --}}
            <div
                class="bg-linear-to-br from-primary/5 to-primary/10 dark:from-primary/10 dark:to-primary/20 rounded-xl p-5 space-y-3">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Your Progress') }}
                    </h3>
                    <span class="text-2xl font-bold text-primary">
                        {{ $routine->progress_percentage }}%
                    </span>
                </div>

                <x-progress value="{{ $routine->exercise_logs_completed_count }}"
                    max="{{ $routine->exercise_logs_count }}" class="h-3 rounded-full shadow-inner" />

                {{-- Progress Text --}}
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ $routine->exercise_logs_completed_count }}</span>
                        {{ __('of') }}
                        <span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ $routine->exercise_logs_count }}</span>
                        {{ __('exercises completed') }}
                    </p>
                </div>
            </div>

            {{-- Exercises List --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <x-icon name="o-list-bullet" class="w-5 h-5" />
                        {{ __('Exercises') }}
                    </h3>
                    <span class="text-sm text-gray-500">
                        {{ $routine->exercise_logs_completed_count }}/{{ $routine->exercise_logs_count }}
                    </span>
                </div>

                <div class="space-y-2">
                    @forelse ($logs as $log)
                        <x-list-item :item="$log"
                            class="rounded-xl border-2 transition-all duration-300 
                                {{ $log->status === 'completed' ? 'border-success/20 bg-success/5' : '' }}
                                {{ $log->status === 'skipped' ? 'border-warning/20 bg-warning/5' : '' }}
                                {{ $log->status === 'pending' ? 'border-gray-200 dark:border-gray-700 hover:border-primary/30 hover:bg-base-200' : '' }}">

                            {{-- Avatar: Exercise Order Number --}}
                            <x-slot:avatar>
                                <div class="relative">
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg
                                        {{ $log->status === 'completed' ? 'bg-success text-success-content' : '' }}
                                        {{ $log->status === 'skipped' ? 'bg-warning text-warning-content' : '' }}
                                        {{ $log->status === 'pending' ? 'bg-primary text-primary-content' : '' }}">
                                        {{ $log->routineExercise->order }}
                                    </div>
                                    @if ($log->status === 'completed')
                                        <div
                                            class="absolute -top-1 -right-1 w-5 h-5 bg-success rounded-full flex items-center justify-center border-2 border-white dark:border-base-100">
                                            <x-icon name="o-check" class="w-3 h-3 text-white" />
                                        </div>
                                    @elseif($log->status === 'skipped')
                                        <div
                                            class="absolute -top-1 -right-1 w-5 h-5 bg-warning rounded-full flex items-center justify-center border-2 border-white dark:border-base-100">
                                            <x-icon name="o-forward" class="w-3 h-3 text-white" />
                                        </div>
                                    @endif
                                </div>
                            </x-slot:avatar>

                            {{-- Exercise Name --}}
                            <x-slot:value>
                                <span
                                    class="font-semibold text-base
                                    {{ $log->status === 'completed' ? 'line-through text-gray-500 dark:text-gray-400' : 'text-gray-900 dark:text-gray-100' }}
                                    {{ $log->status === 'skipped' ? 'text-gray-600 dark:text-gray-400' : '' }}">
                                    {{ $log->routineExercise->exercise_name }}
                                </span>

                                {{-- Status Badge for Mobile --}}
                                @if ($log->status !== 'pending')
                                    <x-badge
                                        value="{{ $log->status === 'completed' ? __('Completed') : __('Skipped') }}"
                                        class="mt-1 sm:hidden {{ $log->status === 'completed' ? 'badge-success' : 'badge-warning' }}" />
                                @endif
                            </x-slot:value>

                            {{-- Sets x Reps + Additional Info --}}
                            <x-slot:sub-value>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mt-1">
                                    {{-- Equipment --}}
                                    @if ($log->routineExercise->exercise->equipment)
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md">
                                            <x-icon name="o-cube" class="w-3.5 h-3.5 text-primary" />
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ $log->routineExercise->exercise->equipment->name }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Sets --}}
                                    <div
                                        class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md">
                                        <x-icon name="o-arrow-path" class="w-3.5 h-3.5 text-primary" />
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $log->routineExercise->sets }} {{ __('sets') }}
                                        </span>
                                    </div>

                                    {{-- Reps --}}
                                    <div
                                        class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md">
                                        <x-icon name="o-hashtag" class="w-3.5 h-3.5 text-primary" />
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $log->routineExercise->reps }} {{ __('reps') }}
                                        </span>
                                    </div>

                                    {{-- Rest Time --}}
                                    @if ($log->routineExercise->rest_seconds)
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md">
                                            <x-icon name="o-clock" class="w-3.5 h-3.5 text-primary" />
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ __('Rest') }} {{ $log->routineExercise->rest }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Weights --}}
                                    @if ($log->routineExercise->weight_kg)
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md">
                                            <x-icon name="o-scale" class="w-3.5 h-3.5 text-primary" />
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ $log->routineExercise->weight_kg_formatted }}
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
                                            wire:click="skip({{ $log->id }})"
                                            tooltip="{{ __('Skip this exercise') }}" spinner
                                            wire:loading.attr="disabled" wire:target="skip({{ $log->id }})">
                                            <span class="hidden md:inline">{{ __('Skip') }}</span>
                                        </x-button>

                                        {{-- Complete Button --}}
                                        <x-button icon="o-check-circle" class="btn-success btn-sm"
                                            wire:click="complete({{ $log->id }})"
                                            tooltip="{{ __('Mark as completed') }}" spinner
                                            wire:loading.attr="disabled" wire:target="complete({{ $log->id }})">
                                            <span class="hidden md:inline">{{ __('Complete') }}</span>
                                        </x-button>
                                    </div>
                                @elseif($log->status === 'completed')
                                    <x-badge value="{{ __('Completed') }}"
                                        class="badge-success hidden sm:inline-flex" />
                                @elseif($log->status === 'skipped')
                                    <x-badge value="{{ __('Skipped') }}" class="badge-warning hidden sm:inline-flex" />
                                @endif
                            </x-slot:actions>
                        </x-list-item>
                    @empty
                        <x-alert title="{{ __('No Exercises Found') }}"
                            description="{{ __('There are no exercises assigned to this routine.') }}"
                            icon="o-information-circle" class="alert-info" />
                    @endforelse
                </div>
            </div>

            {{-- Warning if there are skipped exercises --}}
            @if ($logs->where('status', 'skipped')->count() > 0 && $logs->where('status', 'pending')->count() == 0)
                <div class="bg-warning/10 border-l-4 border-warning rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <x-icon name="o-exclamation-triangle" class="w-5 h-5 text-warning shrink-0.5" />
                        <div>
                            <p class="text-sm font-medium text-warning-content">
                                {{ __('You have skipped exercises') }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                {{ __('Consider completing them in your next session for better results.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <x-slot:actions separator>
            <x-button label="{{ __('Cancel Routine') }}" icon="o-x-mark" class="btn-outline btn-error"
                wire:click="confirmCancelRoutine({{ $routine->id }})" spinner />
        </x-slot:actions>
    </x-card>

    {{-- Modal de Rutina Completada --}}
    <x-modal wire:model="showRoutineCompletedModal" title="" persistent>
        <div class="text-center space-y-6 py-4">
            {{-- Icon/Animation --}}
            <div class="flex justify-center">
                <div class="w-20 h-20 bg-success/10 rounded-full flex items-center justify-center">
                    <x-icon name="o-trophy" class="w-12 h-12 text-success" />
                </div>
            </div>

            {{-- Title --}}
            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    🎉 {{ __('¡Rutina Finalizada!') }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('¡Excelente trabajo! Has completado tu sesión de entrenamiento.') }}
                </p>
            </div>

            {{-- Estadísticas --}}
            <div
                class="bg-linear-to-br from-success/5 to-success/10 dark:from-success/10 dark:to-success/20 rounded-xl p-6 space-y-4">
                {{-- Total --}}
                <div class="flex justify-between items-center pb-3 border-b border-success/20">
                    <span class="text-gray-700 dark:text-gray-300 font-medium">{{ __('Total de ejercicios') }}</span>
                    <span
                        class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $routine->exercise_logs_count }}</span>
                </div>

                {{-- Grid de estadísticas --}}
                <div class="grid grid-cols-2 gap-4">
                    {{-- Completados --}}
                    <div class="bg-white dark:bg-base-300 rounded-lg p-4">
                        <div class="flex flex-col items-center gap-2">
                            <x-icon name="o-check-circle" class="w-8 h-8 text-success" />
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Completados') }}</span>
                            <span
                                class="text-3xl font-bold text-success">{{ $logs->where('status', 'completed')->count() }}</span>
                        </div>
                    </div>

                    {{-- Saltados --}}
                    <div class="bg-white dark:bg-base-300 rounded-lg p-4">
                        <div class="flex flex-col items-center gap-2">
                            <x-icon name="o-forward" class="w-8 h-8 text-warning" />
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saltados') }}</span>
                            <span
                                class="text-3xl font-bold text-warning">{{ $logs->where('status', 'skipped')->count() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Completion Percentage --}}
                <div class="pt-3 border-t border-success/20">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ __('Porcentaje de completitud') }}
                        </p>
                        <p class="text-4xl font-bold text-success">{{ $routine->progress_percentage }}%</p>
                    </div>
                </div>
            </div>

            {{-- Warning si hay ejercicios saltados --}}
            @if ($logs->where('status', 'skipped')->count() > 0)
                <div class="bg-warning/10 border border-warning/30 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <x-icon name="o-light-bulb" class="w-5 h-5 text-warning shrink-0 mt-0.5" />
                        <p class="text-sm text-left text-gray-700 dark:text-gray-300">
                            {{ __('Has saltado algunos ejercicios. Considera completarlos en tu próxima sesión para obtener mejores resultados.') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <x-slot:actions>
            <x-button label="{{ __('Ver mis rutinas') }}" wire:click="closeCompletedModal"
                class="btn-primary btn-block" icon="o-arrow-right" />
        </x-slot:actions>
    </x-modal>

    {{-- Modal de Confirmación de Cancelación --}}
    <x-modal wire:model="showCancelRoutineModal" title="{{ __('Cancel Routine') }}">
        <div class="space-y-4">
            <div class="flex items-start gap-3">
                <x-icon name="o-exclamation-triangle" class="w-6 h-6 text-error shrink-0 mt-1" />
                <div>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ __('Are you sure you want to cancel this routine?') }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        {{ __('This action cannot be undone. Your progress will be saved but the routine will be marked as cancelled.') }}
                    </p>
                </div>
            </div>
        </div>

        <x-slot:actions>
            <x-button label="{{ __('No, keep it') }}" wire:click="$set('showCancelRoutineModal', false)" />
            <x-button label="{{ __('Yes, cancel routine') }}" wire:click="cancelRoutine" class="btn-error"
                spinner />
        </x-slot:actions>
    </x-modal>
</div>
