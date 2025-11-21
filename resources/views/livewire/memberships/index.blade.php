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
        <x-memberships.active-card :activeMembership="$activeMembership" class="mb-6" />
    @else
        <x-memberships.no-active-alert class="mb-6" />
    @endif

    {{-- HISTORIAL DE MEMBRESÍAS --}}
    <x-memberships.history-card :pastMemberships="$pastMemberships" />
</div>
