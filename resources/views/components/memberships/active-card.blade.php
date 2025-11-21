<x-card title="{{ $activeMembership->membership_name }}" shadow class="mb-6">
    <div>
        <div class="mb-4">
            <span class="text-sm">
                {{ $activeMembership->membership_description }}
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="font-medium">
                    {{ __('Started on') }}</span>
                <p>
                    {{ $activeMembership->start_at_formatted }}
                </p>
            </div>
            <div>
                <span class="font-medium">
                    {{ __('Ends on') }}</span>
                <p>
                    {{ $activeMembership->end_at_formatted }}
                </p>
            </div>
            <div>
                <span class="font-medium">
                    {{ __('Price') }}</span>
                <p>
                    {{ $activeMembership->membership_price }}
                </p>
            </div>
        </div>
    </div>
    <x-slot:menu>
        <x-badge value="{{ $activeMembership->status_label }}" class="badge-success" />
    </x-slot:menu>
    <x-slot:actions separator>
        <x-button label="{{ __('View payments') }}" icon="o-currency-dollar"
            link="{{ route('memberships.payments', $activeMembership) }}" class="btn-primary" />
        @if ($activeMembership->isExpiringSoon())
            <x-button label="{{ __('Renew') }}" icon="o-arrow-path" link="#" class="btn-secondary" spinner />
        @endif
    </x-slot:actions>
</x-card>
