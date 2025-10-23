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
        return UserMembership::all();
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
            [
                'label' => 'List',
            ],
        ];
    @endphp

    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- LIST ITEM -->
    <x-card shadow>
        @forelse ($memberships as $membership)
            <x-list-item :item="$membership" value="membership_name" sub-value="membership_description"
                link="{{ route('memberships.show', $membership) }}">
                <x-slot:avatar>
                    <x-badge value="{{ $membership->status }}" class="badge-primary badge-soft" />
                </x-slot:avatar>
            </x-list-item>
        @empty
            {{-- NO RESULTS --}}
            <x-alert title="Nothing here!" description="Try to remove some filters." icon="o-exclamation-triangle"
                class="bg-base-100 border-none">
                <x-slot:actions>
                    <x-button label="Clear filters" wire:click="clear" icon="o-x-mark" spinner />
                </x-slot:actions>
            </x-alert>
        @endforelse
    </x-card>
</div>
