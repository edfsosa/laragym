<div class="p-6 sm:p-8 space-y-10 bg-white dark:bg-gray-950 rounded-xl shadow-sm">

    {{-- Rutinas activas --}}
    @if ($activeRoutines->count())
        <section>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('Active Routines') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($activeRoutines as $routine)
                    <x-routines.card :routine="$routine" wire:key="routine-{{ $routine->id }}" />
                @endforeach
            </div>
        </section>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                {{ __('No active routines.') }}
            </p>
        </div>
    @endif

    {{-- Rutinas completadas con acordeón --}}
    <section x-data="{ open: false }" class="pt-10 border-t border-gray-200 dark:border-gray-800">

        <button @click="open = !open"
            class="flex items-center justify-between w-full text-left text-xl font-semibold text-gray-800 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition">
            {{ __('Completed Routines') }}
            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 ml-2 transform transition-transform duration-200"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-transition x-cloak class="mt-4">
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($completedRoutines as $routine)
                    <x-routines.card :routine="$routine" wire:key="completed-{{ $routine->id }}" />
                @endforeach
            </div>
        </div>

    </section>

    {{-- Modal con detalles --}}
    @if ($showModal && $selectedRoutine)
        <x-routines.details-modal :selectedRoutine="$selectedRoutine" :completedExercises="$completedExercises" />
    @endif
</div>
