<x-card title="{{ __('History') }}" shadow>
    @forelse ($pastMemberships as $membership)
        <x-list-item :item="$membership" value="membership_name" no-separator>
            <x-slot:avatar>
                <x-badge value="{{ $membership->status_label }}" class="badge-error" />
            </x-slot:avatar>
            <x-slot:actions>
                <x-button label="{{ __('View') }}" icon="o-eye" link="{{ route('memberships.show', $membership) }}"
                class="btn-primary" />
            </x-slot:actions>
        </x-list-item>
    @empty
        <x-alert title="{{ __('No past memberships found') }}" description="{{ __('You have no previous memberships.') }}"
            icon="o-check-circle" />
    @endforelse
</x-card>
