<div class="p-6 sm:p-8 space-y-8 bg-white dark:bg-gray-950 rounded-xl shadow-sm">

    {{-- Title --}}
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
        {{ __('My Trainers') }}
    </h1>

    {{-- Trainers Grid --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @if ($trainers->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400 col-span-full">
                {{ __('No trainers found. Please check back later.') }}
            </p>
        @else
            @foreach ($trainers as $trainer)
                <x-trainers.trainer-card :trainer="$trainer" wire:key="trainer-{{ $trainer->id }}" />
            @endforeach
        @endif
    </div>

    {{-- Modal --}}
    @if ($showModal && $selectedTrainer)
        <x-trainers.trainer-modal :trainer="$selectedTrainer" wire:key="trainer-modal-{{ $selectedTrainer->id }}" />
    @endif
</div>
