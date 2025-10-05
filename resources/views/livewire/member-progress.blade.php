<div class="p-6 space-y-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
        {{ __('Progress Overview') }}
    </h1>

    {{-- 🔹 Tarjetas resumen --}}
    @php
        $latest = $progressData->last();
    @endphp
    <div class="grid sm:grid-cols-3 gap-4">
        <div
            class="rounded-xl bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-200 dark:border-indigo-700 p-4 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Current Weight') }}</p>
            <h2 class="text-2xl font-semibold text-indigo-700 dark:text-indigo-300">{{ $latest['weight'] }} kg</h2>
        </div>
        <div
            class="rounded-xl bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-200 dark:border-indigo-700 p-4 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Muscle Mass') }}</p>
            <h2 class="text-2xl font-semibold text-indigo-700 dark:text-indigo-300">{{ $latest['muscle'] }}%</h2>
        </div>
        <div
            class="rounded-xl bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-200 dark:border-indigo-700 p-4 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Body Fat') }}</p>
            <h2 class="text-2xl font-semibold text-indigo-700 dark:text-indigo-300">{{ $latest['fat'] }}%</h2>
        </div>
    </div>

    {{-- 🔹 Línea temporal de mejoras --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            {{ __('Progress Timeline') }}
        </h2>

        <ol class="relative border-s border-indigo-300 dark:border-indigo-700">
            @foreach ($progressData as $item)
                <li class="mb-6 ms-4">
                    <div
                        class="absolute w-3 h-3 bg-indigo-600 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900">
                    </div>
                    <time class="text-sm text-gray-500 dark:text-gray-400">{{ $item['date'] }}</time>
                    <h3 class="text-md font-semibold text-gray-900 dark:text-white">
                        {{ __('Weight:') }} {{ $item['weight'] }} kg
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Muscle:') }} {{ $item['muscle'] }}% | {{ __('Fat:') }} {{ $item['fat'] }}%
                    </p>
                </li>
            @endforeach
        </ol>
    </div>
</div>
