@props(['card'])

<a href="{{ $card['url'] ?? '#' }}"
    class="group relative rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-6 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

    {{-- Ícono decorativo dinámico --}}
    <div class="absolute -top-3 -right-3 bg-indigo-600 dark:bg-indigo-500 text-white p-2 rounded-lg shadow-md">
        <x-dynamic-component :component="$card['icon'] ?? 'heroicon-o-chart-bar'" class="w-5 h-5" />
    </div>

    {{-- Título --}}
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
        {{ $card['title'] }}
    </h3>

    {{-- Descripción --}}
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-snug">
        {{ $card['description'] }}
    </p>

    {{-- Valor --}}
    <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">
        {{ $card['value'] }}
    </p>

</a>
