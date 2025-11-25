<?php

use Livewire\WithPagination;
use App\Models\UserRoutine;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

new #[Title('Routines History')] class extends Component {
    use Toast;
    use WithPagination;

    #[Url(as: 'status')]
    public string $statusFilter = 'all';

    #[Url(as: 'q')]
    public string $search = '';

    public array $sortBy = ['column' => 'assigned_at', 'direction' => 'desc'];

    /**
     * Limpia los filtros de búsqueda y estado.
     */
    public function clear(): void
    {
        $this->reset(['search', 'statusFilter']);
        $this->resetPage();
    }

    /**
     * Resetea la paginación cuando cambia la búsqueda.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Resetea la paginación cuando cambia el filtro de estado.
     */
    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Rutinas completadas o canceladas del usuario autenticado.
     */
    #[Computed]
    public function routines(): LengthAwarePaginator
    {
        return UserRoutine::query()
            ->with(['routine:id,name,description,level,duration_minutes,type,muscle_group', 'assignedBy:id,name'])
            ->withCount('exerciseLogs')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['completed', 'cancelled'])
            ->when($this->statusFilter !== 'all', fn($query) => $query->where('status', $this->statusFilter))
            ->when($this->search, fn($query, $search) => $query->whereHas('routine', fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")))
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);
    }

    /**
     * Opciones para el filtro de estado.
     */
    #[Computed]
    public function statusOptions(): array
    {
        return [['id' => 'all', 'name' => __('All statuses')], ['id' => 'completed', 'name' => __('Completed')], ['id' => 'cancelled', 'name' => __('Cancelled')]];
    }

    /**
     * Estadísticas del historial de rutinas.
     */
    #[Computed]
    public function stats(): array
    {
        $userId = auth()->id();

        return [
            'total' => UserRoutine::where('user_id', $userId)
                ->whereIn('status', ['completed', 'cancelled'])
                ->count(),
            'completed' => UserRoutine::where('user_id', $userId)->where('status', 'completed')->count(),
            'cancelled' => UserRoutine::where('user_id', $userId)->where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Breadcrumbs para la navegación.
     */
    #[Computed]
    public function breadcrumbs(): array
    {
        return [
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
                'label' => __('History'),
                'icon' => 'o-clock',
            ],
        ];
    }

    /**
     * Datos para la vista.
     */
    public function with(): array
    {
        return [
            'routines' => $this->routines,
            'statusOptions' => $this->statusOptions,
            'stats' => $this->stats,
            'breadcrumbs' => $this->breadcrumbs,
        ];
    }
};
?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Routines History') }}" separator>
        <x-slot:actions>
            <x-button link="/routines" label="{{ __('Back to Routines') }}" icon="o-arrow-left" class="btn-ghost" />
        </x-slot:actions>
    </x-header>

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <x-stat title="{{ __('Total Routines') }}" value="{{ $stats['total'] }}" icon="o-clipboard-document-list"
            tooltip="{{ __('Total number of routines completed or cancelled.') }}" color="text-primary" />
        <x-stat title="{{ __('Completed Routines') }}" value="{{ $stats['completed'] }}" icon="o-check-circle"
            tooltip="{{ __('Total number of routines completed successfully.') }}" color="text-success" />
        <x-stat title="{{ __('Cancelled Routines') }}" value="{{ $stats['cancelled'] }}" icon="o-x-circle"
            tooltip="{{ __('Total number of routines that were cancelled.') }}" color="text-error" />
    </div>

    {{-- FILTROS --}}
    <div class="grid gap-3 mb-4 lg:grid-cols-12">
        {{-- Búsqueda --}}
        <div class="lg:col-span-8">
            <x-input placeholder="{{ __('Search routines...') }}" wire:model.live.debounce="search"
                icon="o-magnifying-glass" clearable />
        </div>

        {{-- Filtro de estado --}}
        <div class="lg:col-span-3">
            <x-select :options="$statusOptions" wire:model.live="statusFilter" icon="o-funnel" />
        </div>

        {{-- Botón limpiar --}}
        <div class="lg:col-span-1">
            <x-button icon="o-x-mark" wire:click="clear" class="btn-ghost w-full" :tooltip="__('Clear filters')" spinner />
        </div>
    </div>

    {{--  TABLA DE RUTINAS --}}
    @php
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'routine.name', 'label' => __('Routine')],
            ['key' => 'assignedBy.name', 'label' => __('Assigned by')],
            ['key' => 'assigned_at', 'label' => __('Assigned at'), 'format' => ['date', 'd/m/Y H:i']],
            ['key' => 'completed_at', 'label' => __('Completed at'), 'format' => ['date', 'd/m/Y H:i']],
            ['key' => 'exercise_logs_count', 'label' => __('Exercises')],
            ['key' => 'status_translated', 'label' => __('Status')],
        ];
    @endphp

    <x-table :headers="$headers" :rows="$routines" striped with-pagination />

</div>
