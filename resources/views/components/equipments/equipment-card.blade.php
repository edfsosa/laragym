<div
    class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition transform hover:-translate-y-1 hover:shadow-lg">
    
    {{-- Image and Status Badge --}}
    <div class="relative">
        <img src="{{ $equipment->image }}" alt="{{ $equipment->name }}" class="w-full h-48 object-cover">
        <span
            class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full
                        @if ($equipment->status === 'Available') text-white bg-green-500
                        @elseif($equipment->status === 'Maintenance') bg-yellow-500
                        @elseif($equipment->status === 'Out of Order') text-white bg-red-500
                        @else @endif">
            {{ $equipment->status }}
        </span>
    </div>

    {{-- Name, Type and View Details Button --}}
    <div class="p-4 space-y-2">
        <h2 class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">
            {{ $equipment->name }}
        </h2>
        <p class="text-sm text-indigo-500 font-medium">
            {{ $equipment->type }}
        </p>

        <button wire:click="viewEquipment({{ $equipment->id }})"
            class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 transition">
            {{ __('View Details') }}
        </button>
    </div>
</div>
