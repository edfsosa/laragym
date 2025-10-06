<div
    class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 shadow-md hover:shadow-lg transition duration-200">

    {{-- Imagen del ejercicio --}}
    <div class="mb-4">
        <img src="{{ $exercise->image }}" alt="{{ $exercise->name }}"
            class="w-full h-40 object-contain rounded-md bg-gray-100 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
    </div>

    {{-- Nombre del ejercicio --}}
    <h2 class="text-lg font-bold text-gray-900 dark:text-white truncate">
        {{ $exercise->name }}
    </h2>

    {{-- Grupo muscular --}}
    <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-400 mt-1">
        {{ $exercise->muscle_group }}
    </p>

    {{-- Botón ver detalle --}}
    <div class="mt-5 flex justify-end">
        <button wire:click="viewDetails('{{ $exercise->name }}')"
            class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 dark:text-indigo-300 hover:text-indigo-800 dark:hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m0 0l3-3m-3 3l3 3" />
            </svg>
            {{ __('View Details') }}
        </button>
    </div>
</div>
