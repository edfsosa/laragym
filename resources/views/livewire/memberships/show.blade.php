<?php

use App\Models\UserMembership;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Membership Details')] class extends Component {
    use Toast;

    public UserMembership $membership;
}; ?>

<div>
    {{--  TITLE  --}}
    <x-header :title="__('Membership Details')" separator />

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

    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <x-card shadow class="mb-6">
        <div class="mt-2">
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                {{ __('Started on :date', ['date' => $membership->start_at_formatted]) }}
            </p>
            @if ($membership->end_at)
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    {{ __('Ends on :date', ['date' => $membership->end_at_formatted]) }}
                </p>
            @endif
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                {{ __('Price: :price', ['price' => $membership->membership_price]) }}
            </p>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                {{ __('Description: :description', ['description' => $membership->membership_description]) }}
            </p>
        </div>
        <x-slot:title>
            {{ $membership->membership_name }}
        </x-slot:title>
        <x-slot:menu>
            <x-badge value="{{ $membership->status_label }}" />
        </x-slot:menu>
        <x-slot:actions separator>
            <x-button link="{{ route('memberships.payments', $membership) }}" class="btn-primary mt-4"
                label="{{ __('View payments') }}" icon="o-currency-dollar" />
        </x-slot:actions>
    </x-card>
</div>
