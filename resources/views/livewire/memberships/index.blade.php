<?php

use App\Models\UserMembership;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Memberships')] class extends Component {
    use Toast;

    public function activeMembership(): ?UserMembership
    {
        return UserMembership::query()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest('start_at') // o 'created_at'
            ->first();
    }

    public function pastMemberships(): Collection
    {
        return UserMembership::query()
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'active')
            ->orderByDesc('start_at')
            ->get();
    }

    public function with(): array
    {
        return [
            'activeMembership' => $this->activeMembership(),
            'pastMemberships' => $this->pastMemberships(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Memberships') }}" separator progress-indicator />

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => '/dashboard',
            ],
            [
                'label' => __('Memberships'),
                'link' => '/memberships',
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    {{-- MEMBRESÍA ACTIVA --}}
    @if ($activeMembership)
        <x-card title="{{ $activeMembership->membership_name }}" shadow
            class="mb-6 bg-green-50 dark:bg-green-900 ring-1 ring-green-300">
            <div class="mt-2">
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    {{ __('Started on :date', ['date' => $activeMembership->start_at_formatted]) }}
                </p>
                @if ($activeMembership->end_at)
                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                        {{ __('Ends on :date', ['date' => $activeMembership->end_at_formatted]) }}
                    </p>
                @endif
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    {{ __('Price: :price', ['price' => $activeMembership->membership_price]) }}
                </p>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    {{ __('Description: :description', ['description' => $activeMembership->membership_description]) }}
                </p>
            </div>
            <x-slot:menu>
                <x-badge value="{{ $activeMembership->status_label }}" class="badge-success" />
            </x-slot:menu>
            <x-slot:actions separator>
                <x-button link="{{ route('memberships.payments', $activeMembership) }}" class="btn-primary mt-4"
                    label="{{ __('View payments') }}" icon="o-currency-dollar" />
            </x-slot:actions>
        </x-card>
    @else
        <x-alert title="{{ __('No active membership') }}"
            description="{{ __('You do not have an active membership currently.') }}" icon="o-information-circle"
            class="mb-6" />
    @endif

    {{-- HISTORIAL DE MEMBRESÍAS --}}
    <x-header title="{{ __('Past memberships') }}" size="md" separator />
    @forelse ($pastMemberships as $membership)
        <x-card shadow class="mb-4">
            <x-list-item :item="$membership" value="membership_name" sub-value="membership_description"
                link="{{ route('memberships.show', $membership) }}">
                <x-slot:avatar>
                    <x-badge value="{{ $membership->status_label }}"
                        class="badge-error" />
                </x-slot:avatar>
            </x-list-item>
        </x-card>
    @empty
        <x-alert title="{{ __('No past memberships found') }}" description="{{ __('You have no previous memberships.') }}"
            icon="o-check-circle" />
    @endforelse
</div>
