<div
    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col items-center">

    {{-- Avatar --}}
    <img src="{{ $trainer->photo }}" alt="{{ $trainer->name }}"
        class="w-24 h-24 object-cover rounded-full border-4 border-indigo-500 dark:border-indigo-400 mb-4 shadow-md">

    {{-- Nombre --}}
    <h2 class="text-base font-bold text-gray-900 dark:text-white text-center">
        {{ $trainer->name }}
    </h2>

    {{-- Especialidad --}}
    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mt-1">
        {{ $trainer->specialty ?? __('General Trainer') }}
    </p>

    {{-- Rating --}}
    <div class="mt-2 text-yellow-500 text-sm flex items-center justify-center gap-1">
        <span>⭐</span> <span>{{ $trainer->rating ?? 'N/A' }} / 5.0</span>
    </div>

    {{-- Botón --}}
    <div class="mt-4 w-full">
        <button wire:click="viewTrainer({{ $trainer->id }})"
            class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
            {{ __('View Profile') }}
        </button>
    </div>
</div>
