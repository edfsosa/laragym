<x-alert title="{{ __('No results found') }}"
    description="{{ __('Try adjusting your search or filter to find what you are looking for.') }}"
    icon="o-exclamation-triangle" class="col-span-full">
    <x-slot:actions>
        <x-button label="{{ __('Clear Search') }}" wire:click="clear" icon="o-x-mark" class="btn-primary" spinner />
    </x-slot:actions>
</x-alert>
