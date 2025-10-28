<?php

use App\Models\UserRoutine;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;

new #[Title('Routines')] class extends Component {
    use Toast;

    public function routines(): Collection
    {
        return UserRoutine::query()
            ->where('user_id', auth()->id())
            ->get();
    }

    public function with(): array
    {
        return [
            'routines' => $this->routines(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Routines') }}" separator progress-indicator />

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => '/dashboard',
            ],
            [
                'label' => __('Routines'),
                'link' => '/routines',
            ],
        ];
    @endphp
    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- LIST ITEM -->
    @forelse ($routines as $routine)
        <x-card shadow>
            <x-list-item :item="$routine" value="routine_name" sub-value="routine_description"
                link="{{ route('routines.show', $routine) }}">
                <x-slot:avatar>
                    <x-badge value="{{ $routine->status_translated }}" class="badge-primary" />
                </x-slot:avatar>
            </x-list-item>
        </x-card>
    @empty
        <x-alert title="No routines found"
            description="You do not have any routines at the moment. Please check back later or contact support for more information."
            icon="o-exclamation-triangle" />
    @endforelse
</div>
