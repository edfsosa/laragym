<?php

use App\Models\UserMembership;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Memberships')] class extends Component {
    use Toast;

    public function memberships(): Collection
    {
        return UserMembership::query()
            ->where('user_id', auth()->id())
            ->get();
    }

    public function with(): array
    {
        return [
            'memberships' => $this->memberships(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Memberships" separator progress-indicator />

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
        ];
    @endphp
    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- LIST ITEM -->
    @forelse ($memberships as $membership)
        <x-card shadow>
            <x-list-item :item="$membership" value="membership_name" sub-value="membership_description"
                link="{{ route('memberships.show', $membership) }}">
                <x-slot:avatar>
                    <x-badge value="{{ $membership->status }}" class="badge-primary" />
                </x-slot:avatar>
            </x-list-item>
        </x-card>
    @empty
        <x-alert title="No memberships found"
            description="You do not have any memberships at the moment. Please check back later or contact support for more information."
            icon="o-exclamation-triangle" />
    @endforelse
</div>
