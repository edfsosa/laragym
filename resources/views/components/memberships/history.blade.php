<h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
    {{ __('Membership History') }}
</h3>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($history as $membership)
        <x-memberships.history-card :membership="$membership" />
    @endforeach
</div>
