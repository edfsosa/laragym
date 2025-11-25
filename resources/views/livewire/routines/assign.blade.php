<?php

use App\Models\UserRoutine;
use App\Models\Routine;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;

new #[Title('Asignar Rutina')] class extends Component {
    use Toast;
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public bool $showExercisesModal = false;
    public ?int $selectedRoutineId = null;

    /**
     * Limpia los filtros de búsqueda.
     */
    public function clear(): void
    {
        $this->reset('search');
        $this->resetPage();
    }

    /**
     * Actualiza la búsqueda y resetea la paginación.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Lista de rutinas disponibles para asignar.
     */
    #[Computed]
    public function routines(): LengthAwarePaginator
    {
        return Routine::query()
            ->with(['routineExercises' => fn($q) => $q->orderBy('order')])
            ->withCount('routineExercises')
            ->when($this->search, fn($query, $search) => $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")))
            ->orderByDesc('created_at')
            ->paginate(6);
    }

    /**
     * Rutina seleccionada para ver ejercicios.
     */
    #[Computed]
    public function selectedRoutine(): ?Routine
    {
        if (!$this->selectedRoutineId) {
            return null;
        }

        return Routine::with(['routineExercises' => fn($q) => $q->orderBy('order')])->find($this->selectedRoutineId);
    }

    /**
     * Asigna una rutina al usuario autenticado.
     */
    public function assignRoutine(int $routineId): void
    {
        try {
            $routine = Routine::findOrFail($routineId);
            $user = auth()->user();

            // Verificar si ya está asignada
            if ($this->isRoutineAlreadyAssigned($user->id, $routineId)) {
                $this->warning(__('You have already been assigned this routine.'));
                return;
            }

            // Crear asignación en una transacción
            DB::transaction(function () use ($user, $routineId) {
                UserRoutine::create([
                    'user_id' => $user->id,
                    'routine_id' => $routineId,
                    'assigned_by' => $user->id,
                    'assigned_at' => now(),
                    'status' => 'assigned',
                ]);
            });

            $this->success(__('Routine assigned successfully.'));

            // Redirigir a la vista de rutinas asignadas
            $this->redirect('/routines', navigate: true);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->error(__('Routine not found.'));
        } catch (\Exception $e) {
            $this->error(__('An error occurred while assigning the routine. Please try again.'));
            report($e);
        }
    }

    /**
     * Muestra los ejercicios de una rutina en un modal.
     */
    public function viewExercises(int $routineId): void
    {
        $this->selectedRoutineId = $routineId;

        if (!$this->selectedRoutine) {
            $this->error(__('Routine not found.'));
            return;
        }

        $this->showExercisesModal = true;
    }

    /**
     * Cierra el modal de ejercicios.
     */
    public function closeExercisesModal(): void
    {
        $this->showExercisesModal = false;
        $this->selectedRoutineId = null;
    }

    /**
     * Verifica si el usuario ya tiene asignada esta rutina.
     */
    private function isRoutineAlreadyAssigned(int $userId, int $routineId): bool
    {
        return UserRoutine::query()->where('user_id', $userId)->where('routine_id', $routineId)->where('status', 'assigned')->exists();
    }

    /**
     * Asigna la rutina desde el modal de ejercicios.
     */
    public function assignRoutineFromModal(int $routineId): void
    {
        $this->assignRoutine($routineId);
        $this->closeExercisesModal();
    }

    /**
     * Datos para la vista.
     */
    public function with(): array
    {
        return [
            'routines' => $this->routines,
            'selectedRoutine' => $this->selectedRoutine,
            'hasSearch' => !empty($this->search),
        ];
    }
};
?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Assign Routine') }}" separator>
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
                'label' => __('Assign'),
                'icon' => 'o-plus-circle',
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- SEARCH BAR -->
    <div class="flex gap-2 items-center">
        <x-input placeholder="{{ __('Search routines...') }}" wire:model.live.debounce="search" icon="o-magnifying-glass"
            class="flex-1" />
        @if ($hasSearch)
            <x-button icon="o-x-mark" wire:click="clear" class="btn-ghost" tooltip="{{ __('Clear search') }}" />
        @endif
    </div>

    {{-- ROUTINES LIST --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @forelse ($routines as $routine)
            <x-card title="{{ $routine->name }}" subtitle="{{ $routine->short_description }}" shadow
                class="h-full hover:shadow-lg transition-shadow duration-200">
                {{-- Stats con diseño más visual --}}
                <div class="grid grid-cols-3 gap-2 mb-4">
                    {{-- Duración --}}
                    <div class="text-center p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <x-icon name="o-clock" class="w-5 h-5 mx-auto mb-1 text-primary" />
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Duration') }}</p>
                        <p class="font-semibold text-sm">{{ $routine->duration_formatted }}</p>
                    </div>

                    {{-- Tipo --}}
                    <div class="text-center p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <x-icon name="o-fire" class="w-5 h-5 mx-auto mb-1 text-primary" />
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Type') }}</p>
                        <p class="font-semibold text-sm truncate">{{ $routine->type_translated }}</p>
                    </div>

                    {{-- Ejercicios --}}
                    <div class="text-center p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <x-icon name="o-list-bullet" class="w-5 h-5 mx-auto mb-1 text-primary" />
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Exercises') }}</p>
                        <p class="font-semibold text-sm">
                            {{ $routine->routine_exercises_count ?? $routine->routineExercises->count() }}
                        </p>
                    </div>
                </div>

                {{-- Grupo muscular como tag --}}
                <div class="mb-4">
                    <div
                        class="inline-flex items-center gap-1 px-2 py-1 bg-primary/10 text-primary rounded-full text-xs">
                        <x-icon name="o-heart" class="w-3 h-3" />
                        {{ $routine->muscle_group_translated }}
                    </div>
                </div>

                <x-slot:menu>
                    <x-badge value="{{ $routine->level_translated }}" class="{{ $routine->level_badge }}" />
                </x-slot:menu>

                {{-- Acciones --}}
                <x-slot:actions>
                    <x-button label="{{ __('Assign') }}" icon="o-check" class="btn-primary"
                        wire:click="assignRoutine({{ $routine->id }})"
                        spinner="assignRoutine({{ $routine->id }})" />
                    <x-button icon="o-eye" class="btn-ghost btn-circle"
                        wire:click="viewExercises({{ $routine->id }})" spinner="viewExercises({{ $routine->id }})"
                        :tooltip="__('View Exercises')" />
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

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $routines->links() }}
    </div>

    {{-- EXERCISES MODAL --}}
    <x-modal wire:model="showExercisesModal" title="{{ $selectedRoutine?->name }} - {{ __('Exercises') }}"
        class="backdrop-blur" separator>
        @if ($selectedRoutine)
            <div class="space-y-2 max-h-[70vh] overflow-y-auto">
                @forelse ($selectedRoutine->routineExercises as $index => $exercise)
                    <div
                        class="flex items-center gap-3 p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        {{-- Número --}}
                        <div
                            class="shrink-0 w-8 h-8 rounded-full bg-primary text-primary-content flex items-center justify-center font-bold text-sm">
                            {{ $index + 1 }}
                        </div>

                        {{-- Contenido --}}
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 truncate">
                                {{ $exercise->exercise_name }}
                            </h4>
                            @if ($exercise->notes)
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">
                                    {{ $exercise->notes }}
                                </p>
                            @endif
                        </div>

                        {{-- Info rápida --}}
                        <div class="shrink-0 text-right">
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                @if ($exercise->sets && $exercise->reps)
                                    {{ $exercise->sets }}x{{ $exercise->reps }}
                                @elseif($exercise->duration_seconds)
                                    {{ $exercise->duration_seconds }}s
                                @else
                                    -
                                @endif
                            </div>
                            @if ($exercise->rest_seconds)
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Rest') }}: {{ $exercise->rest_seconds }}s
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ __('No exercises in this routine') }}
                        </p>
                    </div>
                @endforelse
            </div>
        @endif

        <x-slot:actions>
            <x-button label="{{ __('Close') }}" class="btn-ghost" @click="$wire.closeExercisesModal()" />
            @if ($selectedRoutine)
                @php
                    $isAssigned = \App\Models\UserRoutine::where('user_id', auth()->id())
                        ->where('routine_id', $selectedRoutine->id)
                        ->where('status', 'assigned')
                        ->exists();
                @endphp

                @if ($isAssigned)
                    <x-button label="{{ __('Already Assigned') }}" icon="o-check-circle" class="btn-success"
                        disabled />
                @else
                    <x-button label="{{ __('Assign To Me') }}" icon="o-check" class="btn-primary"
                        wire:click="assignRoutineFromModal({{ $selectedRoutine->id }})"
                        spinner="assignRoutineFromModal({{ $selectedRoutine->id }})" />
                @endif
            @endif
        </x-slot:actions>
    </x-modal>
</div>
