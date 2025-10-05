<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
        {{ __('My Trainers') }}
    </h1>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($trainers as $trainer)
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-md transition duration-200">
                <img src="{{ $trainer->photo }}" alt="{{ $trainer->name }}"
                    class="w-24 h-24 object-cover rounded-full mx-auto mb-4 border-4 border-indigo-500">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white text-center">
                    {{ $trainer->name }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-2">
                    {{ $trainer->specialty }}
                </p>
                <p class="text-yellow-500 text-center text-sm mb-3">
                    ⭐ {{ $trainer->rating }} / 5.0
                </p>

                <div class="flex justify-center">
                    <button wire:click="viewTrainer({{ $trainer->id }})"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                        {{ __('View Profile') }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- 🔹 Modal de Perfil --}}
    @if ($showModal && $selectedTrainer)
        <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-lg p-6 relative">
                <button wire:click="closeModal"
                    class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    ✕
                </button>

                <div class="flex flex-col items-center text-center">
                    <img src="{{ $selectedTrainer->photo }}" alt="{{ $selectedTrainer->name }}"
                        class="w-28 h-28 object-cover rounded-full border-4 border-indigo-500 mb-4">

                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $selectedTrainer->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $selectedTrainer->specialty }}</p>
                    <p class="text-yellow-500 text-sm mb-4">⭐ {{ $selectedTrainer->rating }} / 5.0</p>

                    <p class="text-gray-700 dark:text-gray-300 text-sm mb-6">{{ $selectedTrainer->bio }}</p>

                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                        {{ __('Recommended Routines') }}</h3>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        @foreach ($selectedTrainer->routines as $routine)
                            <li>• {{ $routine }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6 flex justify-end">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
