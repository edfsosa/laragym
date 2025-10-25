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
                'label' => 'Home',
                'link' => '/dashboard',
            ],
            [
                'label' => 'Memberships',
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
            <p><strong>Start at:</strong> {{ $membership->start_at->diffForHumans() }}</p>
            <p><strong>Price:</strong> {{ $membership->membership_price }}</p>
        </div>
    </x-card>
</div>
