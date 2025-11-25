<?php

use App\Models\UserMembership;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Computed};
use Mary\Traits\Toast;

new #[Title('Membresías')] class extends Component {
    use Toast;

    /**
     * Obtiene la membresía activa del usuario autenticado
     */
    #[Computed]
    public function activeMembership(): ?UserMembership
    {
        return UserMembership::query()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_at', '>=', now()) // Asegura que no esté vencida
            ->latest('start_at')
            ->first();
    }

    /**
     * Obtiene todas las membresías pasadas del usuario
     */
    #[Computed]
    public function pastMemberships(): Collection
    {
        return UserMembership::query()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['expired', 'cancelled', 'suspended'])
            ->orderByDesc('end_at')
            ->get();
    }

    /**
     * Verifica si el usuario tiene alguna membresía activa
     */
    #[Computed]
    public function hasActiveMembership(): bool
    {
        return $this->activeMembership !== null;
    }

    /**
     * Cuenta el total de membresías históricas
     */
    #[Computed]
    public function totalPastMemberships(): int
    {
        return $this->pastMemberships->count();
    }
}; ?>

<div>
    {{-- HEADER --}}
    <x-header title="{{ __('Memberships') }}" separator progress-indicator />

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
            ],
        ];
    @endphp

    <x-breadcrumbs :items="$breadcrumbs" class="mb-6" />

    {{-- MEMBRESÍA ACTIVA --}}
    @if ($this->hasActiveMembership)
        <x-card title="{{ $this->activeMembership->membership_name }}"
            subtitle="{{ $this->activeMembership->membership_description }}" class="mb-6" shadow>
            <div>
                {{-- Información de la Membresía en Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Fecha de Inicio --}}
                    <div class="bg-base-200 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <x-icon name="o-calendar" label="{{ __('Started on') }}" class="w-4 h-4 text-primary" />
                        </div>
                        <p class="text-lg font-bold">
                            {{ $this->activeMembership->start_at_formatted }}
                        </p>
                    </div>

                    {{-- Fecha de Fin --}}
                    <div class="bg-base-200 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <x-icon name="o-calendar-days" label="{{ __('Ends on') }}" class="w-4 h-4 text-warning" />
                        </div>
                        <p class="text-lg font-bold">
                            {{ $this->activeMembership->end_at_formatted }}
                        </p>
                    </div>

                    {{-- Precio --}}
                    <div class="bg-base-200 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <x-icon name="o-currency-dollar" label="{{ __('Price') }}" class="w-4 h-4 text-success" />
                        </div>
                        <p class="text-lg font-bold">
                            {{ $this->activeMembership->membership_price }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Badge de Estado --}}
            <x-slot:menu>
                <x-badge value="{{ $this->activeMembership->status_label }}" class="badge-success" />
            </x-slot:menu>

            {{-- Acciones --}}
            <x-slot:actions>
                {{-- Ver Pagos --}}
                <x-button label="{{ __('View payments') }}" icon="o-currency-dollar"
                    link="{{ route('memberships.payments', $this->activeMembership) }}" class="btn-primary" />

                {{-- Botón de Renovación (solo si está por vencer) --}}
                @if ($this->activeMembership->isExpiringSoon())
                    <x-button label="{{ __('Renew') }}" icon="o-arrow-path"
                        link="{{ route('memberships.renew', $this->activeMembership) }}" class="btn-secondary"
                        spinner />
                @endif
            </x-slot:actions>
        </x-card>
    @else
        {{-- Sin Membresía Activa - Mejorado con mejor diseño --}}
        <x-alert title="{{ __('No Active Membership') }}"
            description="{{ __('You currently do not have an active membership. Explore our plans and start your fitness journey today!') }}"
            icon="o-identification" class="mt-6">
            <x-slot:actions>
                <x-button label="{{ __('View Plans') }}" icon="o-sparkles" class="btn-primary btn-sm"
                    link="{{ route('memberships.list') }}" />
            </x-slot:actions>
        </x-alert>
    @endif

    {{-- HISTORIAL DE MEMBRESÍAS --}}
    <x-card title="{{ __('History') }}" class="mt-6" shadow>
        {{-- Contador de membresías --}}
        <x-slot:menu>
            @if ($this->pastMemberships->isNotEmpty())
                <x-icon name="o-clock" label="{{ $this->pastMemberships->count() }}" class="w-3 h-3" />
            @endif
        </x-slot:menu>

        @forelse ($this->pastMemberships as $membership)
            <x-list-item :item="$membership" value="membership_name" no-separator>
                {{-- Valor principal con badge inline --}}
                <x-slot:value>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $membership->membership_name }}
                        </span>
                        <x-badge value="{{ $membership->status_label }}"
                            class="{{ $membership->status === 'expired' ? 'badge-error' : ($membership->status === 'cancelled' ? 'badge-warning' : 'badge-neutral') }} badge-sm" />
                    </div>
                </x-slot:value>

                {{-- Subtítulo mejorado con más información --}}
                <x-slot:sub-value>
                    <div class="flex flex-col gap-1.5 text-sm">
                        {{-- Fechas --}}
                        <x-icon name="o-calendar"
                            label="{{ $membership->start_at_formatted }} - {{ $membership->end_at_formatted }}"
                            class="w-3.5 h-3.5 shrink-0" />
                        {{-- Duración --}}
                        <x-icon name="o-clock" label="{{ $membership->duration }}" class="w-3.5 h-3.5 shrink-0" />

                        {{-- Precio --}}
                        <x-icon name="o-currency-dollar" label="{{ $membership->membership_price }}"
                            class="w-3.5 h-3.5 shrink-0" />
                    </div>
                </x-slot:sub-value>

                {{-- Acciones --}}
                <x-slot:actions>
                    <x-button label="{{ __('View') }}" icon="o-eye"
                        link="{{ route('memberships.show', $membership) }}" class="btn-sm btn-primary" />
                </x-slot:actions>
            </x-list-item>
        @empty
            {{-- Estado vacío mejorado --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                {{-- Ilustración/Icono grande --}}
                <div class="relative mb-6">
                    <div class="w-24 h-24 rounded-full bg-base-200 flex items-center justify-center">
                        <x-icon name="o-archive-box" class="w-12 h-12 " />
                    </div>
                </div>

                {{-- Título --}}
                <h3 class="text-xl font-bold-100 mb-4">
                    {{ __('No past memberships found') }}
                </h3>
            </div>
        @endforelse
    </x-card>
</div>
