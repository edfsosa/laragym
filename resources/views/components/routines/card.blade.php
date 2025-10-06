<div
    class="relative rounded-xl border-l-4 border-indigo-500 dark:border-indigo-400 border bg-white dark:bg-gray-900 p-6 shadow-sm hover:shadow-md transition-shadow duration-300 group">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition">
            {{ $routine->name }}
        </h2>

        {{-- Badge de estado --}}
        @php
            $statusColors = [
                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                'active' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
                'paused' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            ];
        @endphp

        <span
            class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $statusColors[$routine->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200' }}">
            {{ $routine->status }}
        </span>
    </div>

    {{-- Detalles --}}
    <div class="space-y-1 text-sm text-gray-700 dark:text-gray-300">
        <p><span class="font-medium">{{ __('Trainer') }}:</span> {{ $routine->trainer }}</p>
        <p><span class="font-medium">{{ __('Assigned on') }}:</span>
            {{ \Carbon\Carbon::parse($routine->assigned_date)->translatedFormat('d M Y') }}</p>
    </div>

    {{-- Botón de acción --}}
    <div class="mt-6 flex justify-end">
        <button wire:click="viewDetails({{ $routine->id }})"
            class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-600 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800 hover:text-indigo-700 dark:hover:text-white transition duration-200 ease-in-out"
            aria-label="View details of {{ $routine->name }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m0 0l3-3m-3 3l3 3" />
            </svg>
            {{ __('View Details') }}
        </button>
    </div>
</div>
