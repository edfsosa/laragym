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

    #[Url]
    public string $search = '';

    public bool $showCancelRoutineModal = false;
    public ?UserRoutine $selectedRoutine = null;

    /**
     * Inicializa el componente.
     */
    public function mount(): void
    {
        // Optimización: usar el método reutilizable en lugar de query duplicada
        $this->hasAssignedRoutines = $this->getBaseQuery()->exists();
    }

    /**
     * Limpia los filtros de búsqueda.
     */
    public function clear(): void
    {
        $this->reset('search');
        $this->resetPage();
    }

    /**
     * Query base para rutinas asignadas (DRY principle).
     */
    private function getBaseQuery()
    {
        return UserRoutine::query()
            ->where('user_id', auth()->id())
            ->where('status', 'assigned');
    }

    /**
     * Rutinas asignadas al usuario autenticado.
     */
    public function routines(): LengthAwarePaginator
    {
        return $this->getBaseQuery()
            ->with(['routine:id,name,description,level', 'assignedBy:id,name'])
            ->withCount([
                'exerciseLogs',
                'exerciseLogs as exercise_logs_completed_count' => function ($query) {
                    $query->where('status', 'completed');
                },
            ])
            ->when($this->search, function ($query) {
                $searchTerm = $this->search;
                $query->whereHas('routine', function ($q) use ($searchTerm) {
                    $q->where(function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', "%{$searchTerm}%")->orWhere('description', 'like', "%{$searchTerm}%");
                    });
                });
            })
            ->orderBy('assigned_at', 'desc')
            ->paginate(6);
    }

    /**
     * Confirma la cancelación de una rutina.
     */
    public function confirmCancelRoutine(int $routineId): void
    {
        $routine = $this->getBaseQuery()->find($routineId);

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

        try {
            $this->selectedRoutine->update(['status' => 'cancelled']);

            // Actualizar el estado hasAssignedRoutines si ya no hay rutinas asignadas
            $this->hasAssignedRoutines = $this->getBaseQuery()->exists();

            $this->reset(['showCancelRoutineModal', 'selectedRoutine']);

            $this->success(__('Routine canceled successfully.'));
        } catch (\Exception $e) {
            $this->error(__('An error occurred while canceling the routine.'));
            \Log::error('Error canceling routine: ' . $e->getMessage());
        }
    }

    /**
     * Observador para actualizar paginación cuando cambia la búsqueda.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Datos para la vista.
     */
    public function with(): array
    {
        return [
            'routines' => $this->routines(),
            'hasSearch' => !empty($this->search),
        ];
    }
};
?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Routines') }}" separator>
        <x-slot:actions>
            <x-button label="{{ __('History') }}" icon="o-clock" class="btn-ghost"
                link="{{ route('routines.history') }}" />
            @if ($hasAssignedRoutines)
                <x-button label="{{ __('New Routine') }}" icon="o-plus" class="btn-primary"
                    link="{{ route('routines.assign') }}" />
            @endif
        </x-slot:actions>
    </x-header>

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => route('dashboard'),
                'icon' => 'o-home',
            ],
            [
                'label' => __('Routines'),
                'link' => route('routines.index'),
                'icon' => 'o-clipboard-document-list',
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- SEARCH -->
    <div class="flex gap-2 items-center">
        <x-input placeholder="{{ __('Search routines...') }}" wire:model.live.debounce="search"
            icon="o-magnifying-glass" class="flex-1" />
        @if ($hasSearch)
            <x-button icon="o-x-mark" wire:click="clear" class="btn-ghost" tooltip="{{ __('Clear search') }}" />
        @endif
    </div>

    <!-- ASSIGNED ROUTINES LIST -->
    @if (!$hasAssignedRoutines)
        <x-alert title="{{ __('No Routines Assigned') }}"
            description="{{ __('You have no routines assigned. Please assign a routine to get started.') }}"
            icon="o-clipboard-document-list" class="mt-6">
            <x-slot:actions>
                <x-button label="{{ __('New Routine') }}" icon="o-plus" class="btn-primary btn-sm"
                    link="{{ route('routines.assign') }}" />
            </x-slot:actions>
        </x-alert>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse ($routines as $routine)
                <x-card :title="$routine->routine_name" shadow
                    class="group hover:shadow-lg transition-all duration-300 border border-base-300 hover:border-primary/30">
                    <!-- Assignment Info -->
                    <div class="flex items-center gap-4 text-sm mb-4">
                        <x-icon name="o-user-circle" class="w-4 h-4" label="{{ $routine->assignedBy->name }}" />
                        <x-icon name="o-calendar" class="w-4 h-4" label="{{ $routine->assigned_at_formatted }}" />
                    </div>

                    <!-- Progress -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">
                                {{ $routine->exercise_logs_completed_count }}/{{ $routine->exercise_logs_count }}
                                {{ __('exercises') }}
                            </span>
                            <span class="text-lg font-bold text-primary">
                                {{ $routine->progress_percentage }}%
                            </span>
                        </div>
                        <x-progress value="{{ $routine->exercise_logs_completed_count }}"
                            max="{{ $routine->exercise_logs_count }}" class="progress-primary h-2" />
                    </div>

                    <x-slot:menu>
                        <x-badge value="{{ $routine->routine_level_translated }}"
                            class="{{ $routine->routine_level_badge }}" />
                    </x-slot:menu>

                    <!-- Actions -->
                    <x-slot:actions>
                        <x-button label="{{ __('View') }}" link="{{ route('routines.show', $routine) }}"
                            icon="o-eye" class="btn-primary" spinner />
                        <x-button label="{{ __('Cancel') }}" icon="o-x-mark" class="btn-ghost text-error"
                            wire:click="confirmCancelRoutine({{ $routine->id }})" spinner />
                    </x-slot:actions>
                </x-card>
            @empty
                {{-- NO RESULTS --}}
                <div class="col-span-full">
                    <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                        <!-- Icon -->
                        <div
                            class="w-16 h-16 rounded-full bg-base-200 dark:bg-base-300 flex items-center justify-center mb-4">
                            <x-icon name="o-magnifying-glass" class="w-8 h-8 text-gray-400" />
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            {{ __('No routines found') }}
                        </h3>

                        <!-- Description -->
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-md">
                            {{ __('Try adjusting your search or filter to find what you are looking for.') }}
                        </p>

                        <!-- Action -->
                        <x-button label="{{ __('Clear Search') }}" wire:click="clear" icon="o-x-mark"
                            class="btn-ghost btn-sm" spinner />
                    </div>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="mt-6">
            {{ $routines->links() }}
        </div>
    @endif

    <!-- CANCEL ROUTINE MODAL -->
    <x-modal wire:model="showCancelRoutineModal" title="{{ __('Cancel Routine') }}" class="backdrop-blur">
        <!-- Warning -->
        <div class="p-3 bg-error/5 border border-error/20 rounded-lg">
            <p class="text-sm">
                {{ __('Are you sure? This action cannot be undone, and you will lose all progress made in this routine.') }}
            </p>
        </div>

        <x-slot:actions>
            <x-button label="{{ __('Close') }}" class="btn-ghost"
                wire:click="$set('showCancelRoutineModal', false)" />
            <x-button label="{{ __('Yes, Cancel') }}" class="btn-error" wire:click="cancelRoutine" icon="o-x-mark"
                spinner />
        </x-slot:actions>
    </x-modal>
</div>
