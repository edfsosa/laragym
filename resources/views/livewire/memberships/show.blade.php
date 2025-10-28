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
    <x-header :title="$membership->membership_name" separator />

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

    {{--  MEMBERSHIP BODY  --}}
    <x-card separator shadow>
        {{--  TITLE --}}
        <x-slot:title>
            {{ $membership->membership_description }}
        </x-slot:title>

        <x-slot:menu>
            <x-badge :value="$membership->status" class="badge-primary" />
        </x-slot:menu>

        <div class="space-y-2">
            <p><strong>{{ __('Started') }}:</strong> {{ $membership->start_at->diffForHumans() }}</p>
            <p><strong>{{ __('Price') }}:</strong> {{ $membership->membership_price }}</p>
        </div>
    </x-card>
</div>
