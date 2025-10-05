<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
        {{ __('My Memberships') }}
    </h1>

    @php
        $active = $memberships->firstWhere('status', 'active');
        $history = $memberships->filter(fn($m) => $m->status !== 'active');
    @endphp

    {{-- 📌 Membresía activa --}}
    {{-- Pagos de la membresía activa --}}
    @if ($active)
        <div
            class="bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-300 dark:border-indigo-700 p-6 rounded-xl shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-semibold text-indigo-800 dark:text-indigo-300">
                        {{ $active->name }}
                    </h2>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                        <strong>{{ __('Price:') }}</strong> {{ $active->price }} <br>
                        <strong>{{ __('Start date:') }}</strong> {{ $active->start_date }} <br>
                        @if ($active->end_date)
                            <strong>{{ __('End date:') }}</strong> {{ $active->end_date }}
                        @else
                            <strong>{{ __('Status:') }}</strong> <span
                                class="text-green-600 dark:text-green-400">{{ __('Ongoing') }}</span>
                        @endif
                    </p>
                </div>
                <span
                    class="text-xs px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full font-medium uppercase">
                    {{ $active->status }}
                </span>
            </div>

            {{-- Lista de pagos --}}
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-2">
                    {{ __('Payments') }}
                </h3>

                @if ($payments->count())
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($payments as $payment)
                            <li class="py-2 flex justify-between items-center text-sm">
                                <div class="text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">{{ $payment->date }}</span> —
                                    {{ $payment->method }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $payment->amount }}</span>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-xs px-2 py-1 rounded-full font-medium
                                                @class([
                                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' =>
                                                        $payment->status === 'paid',
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' =>
                                                        $payment->status === 'pending',
                                                ])">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                        <button wire:click="viewReceipt({{ $loop->index }})"
                                            class="text-indigo-600 dark:text-indigo-400 hover:underline text-xs font-medium">
                                            {{ __('View Receipt') }}
                                        </button>
                                    </div>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('No payments registered yet.') }}
                    </p>
                @endif
            </div>
        </div>
    @endif

    @if ($showReceiptModal && $selectedReceipt)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl max-w-md w-full p-6 relative">
                <button wire:click="closeReceiptModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    ✕
                </button>

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('Payment Receipt') }}
                </h2>

                <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                    <li><strong>{{ __('Date:') }}</strong> {{ $selectedReceipt->date }}</li>
                    <li><strong>{{ __('Amount:') }}</strong> {{ $selectedReceipt->amount }}</li>
                    <li><strong>{{ __('Method:') }}</strong> {{ $selectedReceipt->method }}</li>
                    <li><strong>{{ __('Status:') }}</strong> {{ ucfirst($selectedReceipt->status) }}</li>
                    <li><strong>{{ __('Reference:') }}</strong> {{ $selectedReceipt->reference }}</li>
                </ul>

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('receipts.download', $selectedReceipt->reference) }}" target="_blank"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-800 text-sm text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700">
                        {{ __('Download PDF') }}
                    </a>

                    <button wire:click="closeReceiptModal"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- 📁 Historial --}}
    @if ($history->count())
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Membership History') }}
        </h3>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($history as $membership)
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white">
                            {{ $membership->name }}
                        </h4>
                        <span
                            class="text-xs px-2 py-1 rounded-full font-medium
                            @class([
                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' =>
                                    $membership->status === 'cancelled',
                                'bg-gray-200 text-gray-800 dark:bg-gray-800 dark:text-gray-300' =>
                                    $membership->status !== 'cancelled',
                            ])">
                            {{ ucfirst($membership->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>{{ __('Price:') }}</strong> {{ $membership->price }} <br>
                        <strong>{{ __('Start:') }}</strong> {{ $membership->start_date }} <br>
                        <strong>{{ __('End:') }}</strong> {{ $membership->end_date ?? __('N/A') }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif
</div>
