<?php

use App\Models\UserMembership;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\{Title, Computed};

new #[Title('Detalles de la Membresía')] class extends Component {
    use Toast;

    public UserMembership $membership;

    /**
     * Verifica si la membresía está actualmente activa
     */
    #[Computed]
    public function isActive(): bool
    {
        return $this->membership->status === 'active' && ($this->membership->end_at?->isFuture() ?? false);
    }

    /**
     * Verifica si la membresía está por vencer
     */
    #[Computed]
    public function isExpiringSoon(): bool
    {
        return method_exists($this->membership, 'isExpiringSoon') ? $this->membership->isExpiringSoon() : false;
    }

    /**
     * Obtiene la clase CSS del badge según el estado
     */
    #[Computed]
    public function statusBadgeClass(): string
    {
        return match ($this->membership->status) {
            'active' => 'badge-success',
            'expired' => 'badge-error',
            'cancelled' => 'badge-warning',
            'suspended' => 'badge-neutral',
            default => 'badge-ghost',
        };
    }
}; ?>

<div>
    {{-- HEADER --}}
    <x-header :title="__('Membership Details')" separator progress-indicator>
        <x-slot:actions>
            <x-button label="{{ __('Back to Memberships') }}" icon="o-arrow-left" link="{{ route('memberships.index') }}"
                class="btn-sm" />
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
                'icon' => 'o-identification',
                'link' => route('memberships.index'),
            ],
            [
                'label' => $membership->membership_name,
            ],
        ];
    @endphp

    <x-breadcrumbs :items="$breadcrumbs" class="mb-6" />

    {{-- ALERTA DE ESTADO --}}
    @if ($this->isExpiringSoon && $this->isActive)
        <x-alert title="{{ __('Membership expiring soon') }}"
            description="{{ __('Your membership will expire soon. Renew now to avoid interruption.') }}"
            icon="o-exclamation-triangle" class="alert-warning mb-6">
            <x-slot:actions>
                <x-button label="{{ __('Renew Now') }}" icon="o-arrow-path"
                    link="{{ route('memberships.renew', $membership) }}" class="btn-warning btn-sm" />
            </x-slot:actions>
        </x-alert>
    @elseif (!$this->isActive)
        <x-alert title="{{ __('This membership is not active') }}"
            description="{{ __('This membership has ended or was cancelled.') }}" icon="o-information-circle"
            class="mb-6">
            <x-slot:actions>
                <x-button label="{{ __('View Plans') }}" icon="o-sparkles" link="{{ route('memberships.list') }}"
                    class="btn-primary btn-sm" />
            </x-slot:actions>
        </x-alert>
    @endif

    <x-card title="{{ $membership->membership_name }}" subtitle="{{ $membership->membership_description }}" shadow>
        <x-slot:menu>
            <x-badge value="{{ $membership->status_label }}" class="{{ $this->statusBadgeClass }} badge-lg" />
        </x-slot:menu>

        {{-- Grid de información --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Fecha de inicio --}}
            <div class="bg-base-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <x-icon name="o-calendar" label="{{ __('Started on') }}" class="w-5 h-5 text-success" />
                </div>
                <p class="text-xl font-bold">
                    {{ $membership->start_at_formatted }}
                </p>
            </div>

            {{-- Fecha de fin --}}
            <div class="bg-base-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <x-icon name="o-calendar-days" label="{{ __('Ends on') }}" class="w-5 h-5 text-error" />
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $membership->end_at_formatted }}
                </p>
            </div>

            {{-- Duración --}}
            <div class="bg-base-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <x-icon name="o-clock" label="{{ __('Duration') }}" class="w-5 h-5 text-info" />
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $membership->duration }}
                </p>
            </div>

            {{-- Precio --}}
            <div class="bg-base-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <x-icon name="o-currency-dollar" label="{{ __('Price') }}" class="w-5 h-5 text-warning" />
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $membership->membership_price }}
                </p>
            </div>
        </div>

        {{-- Acciones principales --}}
        <x-slot:actions separator>
            <x-button label="{{ __('View payments') }}" icon="o-currency-dollar"
                link="{{ route('memberships.payments', $membership) }}" class="btn-primary" />

            @if ($this->isActive && $this->isExpiringSoon)
                <x-button label="{{ __('Renew') }}" icon="o-arrow-path"
                    link="{{ route('memberships.renew', $membership) }}" class="btn-secondary" />
            @endif
        </x-slot:actions>
    </x-card>
</div>
