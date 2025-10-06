@props(['trainer'])

<div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-lg p-6 relative">

        {{-- Botón cerrar --}}
        <button wire:click="closeModal"
            class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            ✕
        </button>

        {{-- Contenido del modal --}}
        <div class="flex flex-col items-center text-center">
            <img src="{{ $trainer->photo }}" alt="{{ $trainer->name }}"
                class="w-28 h-28 object-cover rounded-full border-4 border-indigo-500 mb-4">

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ $trainer->name }}
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                {{ $trainer->specialty }}
            </p>

            <p class="text-yellow-500 text-sm mb-4">
                ⭐ {{ $trainer->rating }} / 5.0
            </p>

            <p class="text-gray-700 dark:text-gray-300 text-sm mb-6">
                {{ $trainer->bio }}
            </p>

            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                {{ __('Recommended Routines') }}
            </h3>

            @if (!empty($trainer->routines))
                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                    @foreach ($trainer->routines as $routine)
                        <li>• {{ $routine }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                    {{ __('No routines assigned yet.') }}
                </p>
            @endif
        </div>

        <div class="mt-6 flex justify-end">
            <button wire:click="closeModal"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                {{ __('Close') }}
            </button>
        </div>
    </div>
</div>
