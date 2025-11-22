<x-alert title="{{ __('No active membership') }}"
    description="{{ __('You do not have an active membership currently.') }}" icon="o-information-circle"
    class="col-span-full mb-6">
    <x-slot:actions>
        <x-button label="{{ __('Subscribe Now') }}" link="{{ route('memberships.list') }}" icon="o-shopping-cart"
            class="btn-primary" spinner />
    </x-slot:actions>
</x-alert>
