<div class="p-6 sm:p-8 space-y-8 bg-white dark:bg-gray-950 rounded-xl shadow-sm">

    {{-- Título principal --}}
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
        {{ __('Exercise Catalog') }}
    </h1>

    {{-- Barra de búsqueda --}}
    <div class="flex flex-wrap gap-2">
        @foreach (['All', 'Legs', 'Chest', 'Core', 'Glutes', 'Triceps'] as $group)
            <button wire:click="$set('filterGroup', '{{ $group === 'All' ? '' : $group }}')"
                class="px-4 py-1 text-sm rounded-full border
                    {{ $filterGroup === $group || ($group === 'All' && !$filterGroup)
                        ? 'bg-indigo-600 text-white border-indigo-600'
                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600' }}
                    hover:bg-indigo-50 dark:hover:bg-indigo-700 transition">
                {{ $group }}
            </button>
        @endforeach
    </div>

    {{-- Grilla de ejercicios --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($exercises as $exercise)
            <x-exercises-catalog.card :exercise="$exercise" wire:key="exercise-{{ $exercise->id }}" />
        @endforeach
    </div>

    {{-- Modal con detalles del ejercicio --}}
    @if ($showModal && $selectedExercise)
        <x-exercises-catalog.details-modal :selectedExercise="$selectedExercise" />
    @endif

</div>
