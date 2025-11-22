<?php

use App\Models\UserMembership;
use App\Models\Membership;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Listado de Membresías')]
class extends Component {
    use Toast;
    use WithPagination;

    #[Url]
    public string $search = '';

    /**
     * Limpia los filtros de búsqueda.
     */
    public function clear(): void
    {
        $this->reset();
    }

    /**
     * Lista de membresías disponibles.
     */
    public function memberships(): LengthAwarePaginator
    {
        return Membership::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6);
    }

    /**
     * Une al usuario autenticado a una membresía.
     */
    public function joinMembership(int $membershipId): void
    {
        $membership = Membership::find($membershipId);

        if (!$membership) {
            $this->error(__('Membership not found.'));
            return;
        }

        $user = auth()->user();

        // Evitar duplicados
        if ($user->memberships()->where('membership_id', $membershipId)->exists()) {
            $this->warning(__('You are already a member of: :name', ['name' => $membership->name]));
            return;
        }
        // Unir al usuario a la membresía
        UserMembership::create([
            'user_id' => $user->id,
            'membership_id' => $membershipId,
            'status' => 'active',
            'start_at' => now(),
            'end_at' => now()->addDays($membership->duration_days),
        ]);

        $this->success(__('You have successfully joined the membership: :name', ['name' => $membership->name]));
    }

    /**
     * Datos para la vista.
     */
    public function with(): array
    {
        return [
            'memberships' => $this->memberships(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Memberships') }}" separator />

    {{-- ACTIONS --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <x-button label="{{ __('Go Back') }}" icon="o-arrow-left" class="btn-primary" link="{{ route('memberships.index') }}" />
        <x-input placeholder="Search ..." wire:model.live.debounce="search" icon="o-magnifying-glass" />
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
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- MEMBERSHIPS LIST -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($memberships as $membership)
            <x-memberships.card :membership="$membership" />
        @empty
            <x-alerts.no-results />
        @endforelse
    </div>
    
    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $memberships->links() }}
    </div>
</div>
