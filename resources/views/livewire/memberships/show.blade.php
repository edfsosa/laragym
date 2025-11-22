<?php

use App\Models\UserMembership;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Detalles de la Membresía')] class extends Component {
    use Toast;

    public UserMembership $membership;
}; ?>

<div>
    {{--  HEADER --}}
    <x-header :title="__('Membership Details')" separator />

    {{-- ACTIONS --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <x-button label="{{ __('Go Back') }}" icon="o-arrow-left" class="btn-primary" link="{{ route('memberships.index') }}" />
    </div>

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
            [
                'label' => $membership->membership_name,
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- DETALLES DE LA MEMBRESÍA -->
    <x-card title="{{ $membership->membership_name }}" shadow class="mb-6">
        <div>
            <div class="mb-4">
                <span class="text-sm">
                    {{ $membership->membership_description }}
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium">
                        {{ __('Started on') }}</span>
                    <p>
                        {{ $membership->start_at_formatted }}
                    </p>
                </div>
                <div>
                    <span class="font-medium">
                        {{ __('Ends on') }}</span>
                    <p>
                        {{ $membership->end_at_formatted }}
                    </p>
                </div>
                <div>
                    <span class="font-medium">
                        {{ __('Price') }}</span>
                    <p>
                        {{ $membership->membership_price }}
                    </p>
                </div>
            </div>
        </div>
        <x-slot:menu>
            <x-badge value="{{ $membership->status_label }}" />
        </x-slot:menu>
        <x-slot:actions separator>
            <x-button label="{{ __('View payments') }}" icon="o-currency-dollar"
                link="{{ route('memberships.payments', $membership) }}" class="btn-primary" />
        </x-slot:actions>
    </x-card>
</div>
