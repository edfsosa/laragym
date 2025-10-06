<div class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 px-4">
    <div
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg p-6 relative overflow-hidden animate-fade-in">

        {{-- Botón cerrar --}}
        <button wire:click="closeModal"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition"
            aria-label="Close modal">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Imagen del ejercicio --}}
        <div class="mb-4">
            <img src="{{ $selectedExercise->image }}" alt="{{ $selectedExercise->name }}"
                class="w-full h-56 object-contain rounded-md bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        </div>

        {{-- Título --}}
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
            {{ $selectedExercise->name }}
        </h2>

        {{-- Descripción --}}
        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">
            {{ $selectedExercise->description }}
        </p>

        {{-- Grupo muscular --}}
        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
            {{ __('Muscle group:') }} <span class="capitalize">{{ $selectedExercise->muscle_group }}</span>
        </p>

        {{-- Botón cerrar --}}
        <div class="mt-6 flex justify-end">
            <button wire:click="closeModal"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ __('Close') }}
            </button>
        </div>
    </div>
</div>
