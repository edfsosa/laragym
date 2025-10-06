<div class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 px-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl relative">

        {{-- Botón cerrar (fijo arriba) --}}
        <button wire:click="closeModal"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition z-10"
            aria-label="Close modal">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Contenido con scroll --}}
        <div class="p-6 space-y-4 max-h-[90vh] overflow-y-auto">

            {{-- Título y tipo --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $equipment->name }}
                </h2>
                <p class="text-sm text-indigo-600 dark:text-indigo-400 font-medium capitalize mt-1">
                    {{ $equipment->type }}
                </p>
            </div>

            {{-- Descripción --}}
            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                {{ $equipment->description }}
            </p>

            {{-- Video --}}
            @if ($equipment->video)
                <div class="aspect-w-16 aspect-h-9">
                    <iframe class="rounded-md w-full h-full"
                        src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($equipment->video, 'v=') }}"
                        title="{{ $equipment->name }} video" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            @endif

            {{-- Botón cerrar (parte inferior) --}}
            <div class="mt-6 flex justify-end">
                <button wire:click="closeModal"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>
