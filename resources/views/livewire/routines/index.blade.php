<?php

use App\Models\UserRoutine;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Routines')] class extends Component {
    use Toast;

    public bool $showCancelRoutineModal = false;
    public ?UserRoutine $selectedRoutine = null;

    /**
     * Rutinas asignadas al usuario autenticado.
     */
    public function routines(): Collection
    {
        return UserRoutine::query()
            ->with(['user', 'routine', 'assignedBy'])
            ->withCount('exerciseLogs')
            ->where('user_id', auth()->id())
            ->where('status', 'assigned')
            ->orderBy('assigned_at', 'desc')
            ->get();
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

        $this->selectedRoutine = $routine;
        $this->showCancelRoutineModal = true;
    }

    /**
     * Cancela la rutina seleccionada.
     */
    public function cancelRoutine(): void
    {
        if (!$this->selectedRoutine) {
            $this->error(__('No routine selected for cancellation.'));
            return;
        }

        $this->selectedRoutine->status = 'cancelled';
        $this->selectedRoutine->save();

        $this->showCancelRoutineModal = false;
        $this->selectedRoutine = null;

        $this->success(__('Routine canceled successfully.'));
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
    <x-header title="{{ __('Routines') }}" separator />

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => '/dashboard',
            ],
            [
                'label' => __('Routines'),
            ],
        ];
    @endphp
    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    {{-- ACTIONS --}}
    <div class="flex items-center justify-start mb-6 space-x-2">
        <x-routines.new-routine-button />
        <x-routines.history-button />
    </div>

    <!-- ROUTINES LIST -->
    <x-routines.assigned-list :routines="$routines" />

    <!-- CANCEL ROUTINE MODAL -->
    <x-routines.cancel-modal />
</div>
