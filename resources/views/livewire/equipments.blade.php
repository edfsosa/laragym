<div class="p-6 sm:p-8 space-y-8 bg-white dark:bg-gray-950 rounded-xl shadow-sm">

    {{-- Header --}}
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
        {{ __('Equipment Catalog') }}
    </h1>

    {{-- Equipment Grid --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($equipments as $equipment)
            <x-equipments.equipment-card :equipment="$equipment" wire:key="equipment-{{ $equipment->id }}" />
        @empty
            <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                {{ __('No equipment available at the moment.') }}
            </div>
        @endforelse
    </div>

    {{-- Modal with equipment details --}}
    @if ($showModal && $selectedEquipment)
        <x-equipments.details-modal :equipment="$selectedEquipment" />
    @endif

</div>
