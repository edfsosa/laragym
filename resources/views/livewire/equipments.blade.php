<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
        {{ __('Equipment Catalog') }}
    </h1>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($equipments as $equipment)
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition transform hover:-translate-y-1 hover:shadow-lg">
                <div class="relative">
                    <img src="{{ $equipment->image }}" alt="{{ $equipment->name }}" class="w-full h-48 object-cover">
                    <span
                        class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full
                        @if ($equipment->status === 'Available') bg-indigo-600 text-white
                        @elseif($equipment->status === 'Maintenance') bg-yellow-500 text-white
                        @else bg-red-600 text-white @endif">
                        {{ $equipment->status }}
                    </span>
                </div>

                <div class="p-4 space-y-2">
                    <h2 class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">
                        {{ $equipment->name }}
                    </h2>
                    <p class="text-sm text-indigo-500 font-medium">
                        {{ $equipment->type }}
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3">
                        {{ $equipment->description }}
                    </p>

                    @if ($equipment->video)
                        <a href="{{ $equipment->video }}" target="_blank"
                            class="inline-block mt-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-full transition">
                            🎥 Ver cómo usar
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
