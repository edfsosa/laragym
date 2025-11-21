<?php

use App\Models\UserRoutine;
use App\Models\Routine;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

new #[Title('Asignar Rutina')]
class extends Component {
    use Toast;
    use WithPagination;

    public bool $showExercisesModal = false;
    public $selectedRoutine = null;
    public $exercises = [];

    /**
     * Lista de rutinas disponibles para asignar.
     */
    public function routines(): LengthAwarePaginator
    {
        return Routine::query()->with('routineExercises')->orderBy('created_at', 'desc')->paginate(6);
    }

    /**
     * Asigna una rutina al usuario autenticado.
     */
    public function assignRoutine(int $routineId): void
    {
        $routine = Routine::find($routineId);

        if (!$routine) {
            $this->error(__('Routine not found.'));
            return;
        }

        $user = auth()->user();

        // Evitar duplicados
        $exists = UserRoutine::where('user_id', $user->id)->where('routine_id', $routineId)->where('status', 'assigned')->exists();
        if ($exists) {
            $this->error(__('You have already been assigned this routine.'));
            return;
        }

        // Asignar la rutina al usuario
        UserRoutine::create([
            'user_id' => $user->id,
            'routine_id' => $routineId,
            'assigned_by' => $user->id,
            'assigned_at' => now(),
            'status' => 'assigned',
        ]);

        $this->success(__('Routine assigned successfully.'));
    }

    /**
     * Muestra los ejercicios de una rutina en un modal.
     */
    public function viewExercises(int $routineId): void
    {
        $routine = Routine::with('routineExercises')->find($routineId);

        if (!$routine) {
            $this->error(__('Routine not found.'));
            return;
        }

        $this->selectedRoutine = $routine;
        $this->exercises = $routine->routineExercises;
        $this->showExercisesModal = true;
    }

    /**
     * Datos para la vista.
     */
    public function with(): array
    {
        return [
            'routines' => $this->routines(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Assign Routine') }}" separator />

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
                'label' => __('Assign'),
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    {{-- ACTIONS --}}
    <div class="flex items-center justify-start mb-6 space-x-2">
        <x-routines.go-back-button />
    </div>

    {{-- ROUTINES LIST --}}
    <x-routines.list :routines="$routines" :assignable="true" wire:click:viewExercises="viewExercises" wire:click:assignRoutine="assignRoutine" />

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $routines->links() }}
    </div>

    {{-- EXERCISES MODAL --}}
    <x-routines.exercises-modal :showExercisesModal="$showExercisesModal" :selectedRoutine="$selectedRoutine" :exercises="$exercises" />
</div>
