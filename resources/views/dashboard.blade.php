<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 md:p-6">

        {{-- Welcome Header --}}
        <x-dashboard.header />

        {{-- Cards Section --}}
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($cards as $card)
                <x-dashboard.card :card="$card" />
            @endforeach
        </div>

        {{-- Progress Chart Section --}}
        <x-dashboard.progress-chart :progress="$progress" />
    </div>
</x-layouts.app>
