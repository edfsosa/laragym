<li x-show="{{ $loop->index }} < 3 || showAll" x-transition class="py-2 flex justify-between items-center text-sm">
    <div class="text-gray-700 dark:text-gray-300">
        <span class="font-medium">{{ $payment->date }}</span> —
        {{ $payment->method }}
    </div>
    <div class="flex items-center gap-2">
        <span class="text-indigo-600 dark:text-indigo-400 font-semibold">
            {{ $payment->amount }}
        </span>
        <button wire:click="viewReceipt({{ $loop->index }})"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
            {{ __('View Receipt') }}
        </button>
    </div>
</li>
