<?php

use App\Models\UserRoutine;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Routines')] class extends Component {
    use Toast;
    use WithPagination;

    public bool $hasAssignedRoutines = false;

    /**
     * Inicializa el componente.
     */
    public function mount(): void
    {
        $this->hasAssignedRoutines = UserRoutine::where('user_id', auth()->id())
            ->where('status', 'assigned')
            ->exists();
    }

    #[Url]
    public string $search = '';

    public bool $showCancelRoutineModal = false;
    public ?UserRoutine $selectedRoutine = null;

    /**
     * Limpia los filtros de búsqueda.
     */
    public function clear(): void
    {
        $this->search = '';
    }

    /**
     * Rutinas asignadas al usuario autenticado.
     */
    public function routines(): LengthAwarePaginator
    {
        return UserRoutine::query()
            ->with(['user', 'routine', 'assignedBy'])
            ->withCount('exerciseLogs')
            ->where('user_id', auth()->id())
            ->where('status', 'assigned')
            ->orderBy('assigned_at', 'desc')
            ->when($this->search, function ($query) {
                $query->whereHas('routine', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(6);
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
    <x-header title="{{ __('Routines') }}" separator>
        <x-slot:actions>
            <x-button label="{{ __('New Routine') }}" icon="o-plus" class="btn-primary"
                link="{{ route('routines.assign') }}" />
            <x-button label="{{ __('History') }}" icon="o-clock" class="btn-primary"
                link="{{ route('routines.history') }}" />
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
        ];
    @endphp
    
    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- SEARCH -->
    <x-input placeholder="Search ..." wire:model.live.debounce="search" icon="o-magnifying-glass" />

    <!-- ASSIGNED ROUTINES LIST -->
    @if (!$hasAssignedRoutines)
        <x-alert title="{{ __('No Routines Assigned') }}"
            description="{{ __('You have no routines assigned. Please assign a routine to get started.') }}"
            icon="o-information-circle" class="mb-6" />
    @else
        <x-routines.assigned-list :routines="$routines" />
    @endif

    <!-- CANCEL ROUTINE MODAL -->
    <x-routines.cancel-modal />
</div>
