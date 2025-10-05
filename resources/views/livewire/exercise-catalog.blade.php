<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
        {{ __('Exercise Catalog') }}
    </h1>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($exercises as $exercise)
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4 shadow-sm">
                <img src="{{ $exercise->image }}" alt="{{ $exercise->name }}"
                    class="w-full h-40 object-contain rounded mb-4 bg-gray-100 dark:bg-gray-800">

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $exercise->name }}</h2>
                <p class="text-xs mt-2 text-indigo-600 dark:text-indigo-400 font-medium">
                    {{ $exercise->muscle_group }}
                </p>

                <div class="mt-4 text-right">
                    <button wire:click="viewDetails('{{ $exercise->name }}')"
                        class="text-sm text-indigo-600 hover:underline dark:text-indigo-400">
                        {{ __('View Details') }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal --}}
    @if ($showModal && $selectedExercise)
        <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-lg p-6 relative">
                <button wire:click="closeModal"
                    class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-lg">
                    ✕
                </button>

                <img src="{{ $selectedExercise->image }}" alt="{{ $selectedExercise->name }}"
                    class="w-full h-56 object-contain rounded mb-4 bg-gray-100 dark:bg-gray-800">

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    {{ $selectedExercise->name }}
                </h2>

                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                    {{ $selectedExercise->description }}
                </p>

                <p class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">
                    {{ __('Muscle groups:') }} {{ $selectedExercise->muscle_group }}
                </p>

                <div class="mt-6 flex justify-end">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
