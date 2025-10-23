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
    <x-card class="text-sm/7 mb-10 border border-base-content/10" separator shadow>
        {{--  TITLE --}}
        <x-slot:title class="text-sm flex gap-2 items-center">
            <div class="text-xs font-normal text-base-content/60">
                <p>
                    {{ 'Started ' . $membership->start_at->diffForHumans() }}
                </p>
                <p>
                    {{ 'Price ' . $membership->membership_price }}
                </p>
            </div>
        </x-slot:title>

        <x-slot:menu>
            <x-badge :value="$membership->status" class="badge-primary badge-soft" />
        </x-slot:menu>

        {{--   BODY  --}}
        {!! nl2br(e($membership->membership_description)) !!}
    </x-card>
</div>
