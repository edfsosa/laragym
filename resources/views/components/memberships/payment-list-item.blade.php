<x-list-item :item="$payment" no-separator>
    <x-slot:avatar>
        <x-badge value="{{ $payment->status_label }}" class="badge-primary" />
    </x-slot:avatar>
    <x-slot:value>
        {{ $payment->method_label }}
    </x-slot:value>
    <x-slot:sub-value>
        <div>
            <p>
                {{ $payment->amount_formatted }}
            </p>
            <p>
                {{ $payment->paid_at_formatted }}
            </p>
        </div>
    </x-slot:sub-value>
    <x-slot:actions>
        <x-button icon="o-arrow-down" class="btn-primary"
        wire:click="downloadReceipt({{ $payment->id }})"
            wire:loading.attr="disabled" spinner />
    </x-slot:actions>
</x-list-item>
