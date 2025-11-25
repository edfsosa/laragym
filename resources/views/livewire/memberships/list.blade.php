<?php

use App\Models\UserMembership;
use App\Models\Membership;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\{Title, Computed};

new #[Title('Planes de Membresías')] class extends Component {
    use Toast;

    /**
     * Lista de membresías disponibles
     */
    #[Computed]
    public function memberships(): Collection
    {
        return Membership::query()->where('is_active', true)->orderBy('price', 'asc')->get();
    }

    /**
     * Verifica si el usuario tiene una membresía activa
     */
    #[Computed]
    public function hasActiveMembership(): bool
    {
        return auth()->user()->memberships()->where('status', 'active')->where('end_at', '>=', now())->exists();
    }

    /**
     * Une al usuario autenticado a una membresía
     */
    public function joinMembership(int $membershipId): void
    {
        $membership = Membership::find($membershipId);

        if (!$membership) {
            $this->error(__('Membership not found.'));
            return;
        }

        $user = auth()->user();

        // Verificar si ya tiene una membresía activa
        $activeMembership = $user->memberships()->where('status', 'active')->where('end_at', '>=', now())->first();

        if ($activeMembership) {
            $this->warning(__('You already have an active membership. Please wait until it expires or cancel it first.'));
            return;
        }

        // Crear la nueva membresía
        UserMembership::create([
            'user_id' => $user->id,
            'membership_id' => $membershipId,
            'status' => 'active',
            'start_at' => now(),
            'end_at' => now()->addDays($membership->duration_days),
        ]);

        $this->success(__('Welcome to :name! Your membership is now active.', ['name' => $membership->name]));

        // Redirigir a la página de membresías
        $this->redirect(route('memberships.index'), navigate: true);
    }
}; ?>

<div>
    {{-- HEADER --}}
    <x-header title="{{ __('Available Plans') }}" separator progress-indicator>
        <x-slot:actions>
            <x-slot:actions>
                <x-button label="{{ __('Back to Memberships') }}" icon="o-arrow-left"
                    link="{{ route('memberships.index') }}" class="btn-sm" />
            </x-slot:actions>
        </x-slot:actions>
    </x-header>

    {{-- BREADCRUMBS --}}
    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'icon' => 'o-home',
                'link' => route('dashboard'),
            ],
            [
                'label' => __('Memberships'),
                'icon' => 'o-ticket',
                'link' => route('memberships.index'),
            ],
            [
                'label' => __('Available Plans'),
                'icon' => 'o-sparkles',
            ],
        ];
    @endphp

    <x-breadcrumbs :items="$breadcrumbs" class="mb-6" />

    {{-- ALERTA SI YA TIENE MEMBRESÍA ACTIVA --}}
    @if ($this->hasActiveMembership)
        <x-alert title="{{ __('You already have an active membership') }}"
            description="{{ __('You can view your current membership details or wait until it expires to join a new plan.') }}"
            icon="o-information-circle" class="alert-info mb-6">
            <x-slot:actions>
                <x-button label="{{ __('View') }}" icon="o-eye" link="{{ route('memberships.index') }}"
                    class="btn-primary btn-sm" />
            </x-slot:actions>
        </x-alert>
    @endif

    {{-- GRID DE MEMBRESÍAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @forelse ($this->memberships as $membership)
            <x-card title="{{ $membership->name }}" subtitle="{{ $membership->description }}" shadow
                class="hover:shadow-xl transition-shadow duration-300 {{ $this->hasActiveMembership ? 'opacity-75' : '' }}">

                {{-- Precio destacado --}}
                <div class="mb-6 text-center py-4 bg-linear-to-br from-primary/10 to-secondary/10 rounded-lg">
                    <div class="flex items-baseline justify-center gap-1">
                        <span class="text-4xl font-bold text-primary">
                            {{ $membership->price_formatted }}
                        </span>
                        <span class="text-sm">
                            / {{ $membership->duration_days_formatted }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-success/10 flex items-center justify-center shrink-0">
                        <x-icon name="o-clock" class="w-5 h-5 text-success" />
                    </div>
                    <div class="flex-1">
                        <p class="text-xs">{{ __('Duration') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $membership->duration_days_formatted }}
                        </p>
                    </div>
                </div>

                {{-- Botón de acción --}}
                <x-slot:actions>
                    <x-button label="{{ __('Join Now') }}" wire:click="joinMembership({{ $membership->id }})"
                        icon="o-rocket-launch" class="btn-primary w-full" spinner :disabled="$this->hasActiveMembership"
                        tooltip="{{ $this->hasActiveMembership ? __('You already have an active membership') : __('Start your membership today') }}" />
                </x-slot:actions>
            </x-card>
        @empty
            {{-- Estado vacío --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    {{-- Icono --}}
                    <div class="relative mb-6">
                        <div class="w-24 h-24 rounded-full bg-base-200 flex items-center justify-center">
                            <x-icon name="o-exclamation-triangle" class="w-12 h-12" />
                        </div>
                    </div>
    
                    {{-- Título --}}
                    <h3 class="text-xl font-bold mb-4">
                        {{ __('No plans available') }}
                    </h3>
    
                    {{-- Acción --}}
                    <x-button label="{{ __('Back to Memberships') }}" icon="o-identification"
                        link="{{ route('memberships.index') }}" />
                </div>
            </div>
        @endforelse
    </div>
</div>
