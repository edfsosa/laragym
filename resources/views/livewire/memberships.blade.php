<div class="p-6 sm:p-8 space-y-8 bg-white dark:bg-gray-950 rounded-xl shadow-sm">

    {{-- Title --}}
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
        {{ __('My Memberships') }}
    </h1>

    {{-- Active Membership --}}
    @if ($active)
        <x-memberships.active-membership-card :active="$active" :payments="$payments" />
        <x-memberships.payments :payments="$payments" />
    @endif

    {{-- Receipt Modal --}}
    @if ($showReceiptModal && $selectedReceipt)
        <x-memberships.payment-receipt-modal :selectedReceipt="$selectedReceipt" />
    @endif

    {{-- Membership History --}}
    @if ($history->count())
        <x-memberships.history :history="$history" />
    @else
        <p class="text-gray-500 dark:text-gray-400 italic">
            {{ __('No previous memberships found.') }}
        </p>
    @endif
</div>
