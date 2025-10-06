<div class="bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-300 dark:border-indigo-700 p-6 rounded-xl shadow-sm">
    <div class="flex justify-between items-start gap-4">
        {{-- Membership Details --}}
        <div>
            <h2 class="text-lg font-semibold text-indigo-900 dark:text-indigo-200">
                {{ $active->name }}
            </h2>

            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 leading-relaxed space-y-1">
                <p><strong>{{ __('Price:') }}</strong> {{ $active->price }}</p>
                <p><strong>{{ __('Start date:') }}</strong> {{ $active->start_date }}</p>
                @if ($active->end_date)
                    <p><strong>{{ __('End date:') }}</strong> {{ $active->end_date }}</p>
                @else
                    <p>
                        <strong>{{ __('Status:') }}</strong>
                        <span class="text-green-600 dark:text-green-400 font-medium">
                            {{ __('Ongoing') }}
                        </span>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
