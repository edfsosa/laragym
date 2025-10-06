@props(['membership'])

<div x-data="{ open: false }"
    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm transition overflow-hidden">

    {{-- Encabezado clickeable --}}
    <button @click="open = !open"
        class="w-full flex justify-between items-center px-5 py-4 text-left text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition">
        <span>{{ $membership->name }}</span>

        <span class="text-xs px-2 py-1 rounded-full font-semibold
                @class([
                    'bg-red-100 text-red-800 dark:text-red-300' =>
                        $membership->status === 'cancelled',
                    'bg-gray-100 dark:bg-gray-800 dark:text-gray-300' =>
                        $membership->status !== 'cancelled',
                ])">
            {{ ucfirst($membership->status) }}
        </span>
    </button>

    {{-- Contenido desplegable --}}
    <div x-show="open" x-transition class="px-5 pb-5 text-sm text-gray-700 dark:text-gray-300 space-y-1">
        <p><strong>{{ __('Price:') }}</strong> {{ $membership->price }}</p>
        <p><strong>{{ __('Start:') }}</strong> {{ $membership->start_date }}</p>
        <p><strong>{{ __('End:') }}</strong> {{ $membership->end_date ?? __('N/A') }}</p>
    </div>
</div>
