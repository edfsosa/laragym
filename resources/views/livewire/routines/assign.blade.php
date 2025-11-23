<?php

use App\Models\UserRoutine;
use App\Models\Routine;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Asignar Rutina')] class extends Component {
    use Toast;
    use WithPagination;

    #[Url]
    public string $search = '';

    public bool $showExercisesModal = false;
    public $selectedRoutine = null;
    public $exercises = [];

    /**
     * Limpia los filtros de búsqueda.
     */
    public function clear(): void
    {
        $this->reset();
    }

    /**
     * Lista de rutinas disponibles para asignar.
     */
    public function routines(): LengthAwarePaginator
    {
        return Routine::query()
            ->with('routineExercises')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6);
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
    <x-header title="{{ __('Assign Routine') }}" separator>
        <x-slot:actions>
            <x-button link="/routines" label="{{ __('Cancel') }}" icon="o-x-mark" />
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

    <!-- SEARCH INPUT -->
    <x-input placeholder="Search ..." wire:model.live.debounce="search" icon="o-magnifying-glass" />

    {{-- ROUTINES LIST --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @forelse ($routines as $routine)
            <x-card title="{{ $routine->name }}" shadow>
                <div>
                    <div class="mb-4">
                        <span class="text-sm">
                            {{ $routine->short_description }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium">
                                {{ __('Level') }}</span>
                            <p>
                                {{ $routine->level_translated }}
                            </p>
                        </div>
                        <div>
                            <span class="font-medium">
                                {{ __('Duration') }}</span>
                            <p>
                                {{ $routine->duration_minutes }} {{ __('minutes') }}
                            </p>
                        </div>
                        <div>
                            <span class="font-medium">
                                {{ __('Type') }}</span>
                            <p>
                                {{ $routine->type_translated }}
                            </p>
                        </div>
                        <div>
                            <span class="font-medium">
                                {{ __('Muscle group') }}</span>
                            <p>
                                {{ $routine->muscle_group_translated }}
                            </p>
                        </div>
                    </div>
                </div>

                <x-slot:actions separator>
                    <x-button label="{{ __('Assign To Me') }}" icon="o-check" class="btn-primary"
                        wire:click="assignRoutine({{ $routine->id }})" spinner />
                    <x-button label="{{ __('View Exercises') }}" icon="o-list-bullet" class="btn-secondary"
                        wire:click="viewExercises({{ $routine->id }})" spinner />
                </x-slot:actions>
            </x-card>
        @empty
            {{-- NO RESULTS --}}
            <x-alert title="{{ __('No routines found') }}"
                description="{{ __('Try adjusting your search or filter to find what you are looking for.') }}"
                icon="o-exclamation-triangle" class="col-span-full">
                <x-slot:actions>
                    <x-button label="{{ __('Clear Search') }}" wire:click="clear" icon="o-x-mark" class="btn-primary"
                        spinner />
                </x-slot:actions>
            </x-alert>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $routines->links() }}
    </div>

    {{-- EXERCISES MODAL --}}
    <x-modal wire:model="showExercisesModal" title="{{ __('Exercises') }}" class="backdrop-blur">
        @if ($selectedRoutine)
            <ul class="space-y-3">
                @foreach ($exercises as $exercise)
                    <li class="border-b pb-2 flex justify-between">
                        <span class="font-medium">{{ $exercise->exercise_name }}</span>
                        <span class="text-sm">
                            {{ $exercise->sets }} x {{ $exercise->reps }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif

        <x-slot:actions>
            <x-button label="{{ __('Close') }}" class="btn-secondary"
                wire:click="$set('showExercisesModal', false)" />
        </x-slot:actions>
    </x-modal>

</div>
