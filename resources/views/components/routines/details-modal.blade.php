<div class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 px-4">
    <div
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg p-6 border-t-4 border-indigo-600 relative overflow-hidden animate-fade-in">

        {{-- Botón de cerrar --}}
        <button wire:click="closeModal"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition"
            aria-label="Close modal">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Título --}}
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
            {{ $selectedRoutine->name }}
        </h2>

        {{-- Barra de progreso --}}
        @php
            $total = count($selectedRoutine->exercises);
            $done = isset($completedExercises[$selectedRoutine->id])
                ? count($completedExercises[$selectedRoutine->id])
                : 0;
            $percent = $total > 0 ? round(($done / $total) * 100) : 0;
        @endphp

        <div class="mb-4">
            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                <span>{{ $done }} / {{ $total }} {{ __('completed') }}</span>
                <span>{{ $percent }}%</span>
            </div>
            <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-2 bg-indigo-600 transition-all duration-300" style="width: {{ $percent }}%"></div>
            </div>
        </div>

        {{-- Detalles del entrenador --}}
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <strong>{{ __('Trainer') }}</strong>: {{ $selectedRoutine->trainer }} —
            <strong>{{ __('Assigned on') }}</strong>:
            {{ \Carbon\Carbon::parse($selectedRoutine->assigned_date)->translatedFormat('d M Y') }}
        </p>

        {{-- Lista de ejercicios --}}
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Exercises') }}</h3>

        @if (!empty($selectedRoutine->exercises))
            <ul class="space-y-2 max-h-72 overflow-y-auto pr-1">
                @foreach ($selectedRoutine->exercises as $index => $exercise)
                    @php
                        $isCompleted =
                            isset($completedExercises[$selectedRoutine->id]) &&
                            in_array($index, $completedExercises[$selectedRoutine->id]);
                    @endphp
                    <li
                        class="flex items-center justify-between gap-2 px-4 py-3 rounded-xl border transition
                        {{ $isCompleted
                            ? 'bg-green-50 dark:bg-green-900/20 border-green-300 dark:border-green-700'
                            : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700' }}">

                        <div class="flex items-center gap-3">
                            <input type="checkbox"
                                wire:click="toggleExerciseCompletion({{ $selectedRoutine->id }}, {{ $index }})"
                                @checked($isCompleted)
                                class="rounded text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-400">

                            <span
                                class="text-sm {{ $isCompleted ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-800 dark:text-gray-200' }}">
                                {{ $exercise['name'] }}
                            </span>
                        </div>

                        <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $exercise['sets'] }} × {{ $exercise['reps'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-400 text-sm mt-2">{{ __('No exercises found for this routine.') }}</p>
        @endif

        {{-- Botón cerrar --}}
        <div class="mt-6 flex justify-end">
            <button wire:click="closeModal"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ __('Close') }}
            </button>
        </div>
    </div>
</div>
