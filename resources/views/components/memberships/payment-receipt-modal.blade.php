<div class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 px-4">
    <div
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg p-6 relative overflow-hidden animate-fade-in">

        {{-- Close Button --}}
        <button wire:click="closeReceiptModal"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition"
            aria-label="Close modal">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Receipt Title --}}
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            {{ __('Payment Receipt') }}
        </h2>

        {{-- Receipt Details --}}
        <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
            <li><strong>{{ __('Date:') }}</strong> {{ $selectedReceipt->date }}</li>
            <li><strong>{{ __('Amount:') }}</strong> {{ $selectedReceipt->amount }}</li>
            <li><strong>{{ __('Method:') }}</strong> {{ $selectedReceipt->method }}</li>
            <li><strong>{{ __('Status:') }}</strong> {{ ucfirst($selectedReceipt->status) }}</li>
            <li><strong>{{ __('Reference:') }}</strong> {{ $selectedReceipt->reference }}</li>
        </ul>

        {{-- Action Buttons --}}
        <div class="mt-6 flex justify-end gap-3">

            {{-- Download PDF Button --}}
            <a href="{{ route('receipts.download', $selectedReceipt->reference) }}" target="_blank"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-800 text-sm text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700">
                {{ __('Download PDF') }}
            </a>

            {{-- Close Button --}}
            <button wire:click="closeReceiptModal"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                {{ __('Close') }}
            </button>
        </div>
    </div>
</div>
