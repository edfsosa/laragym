<div x-data="{ open: true, showAll: false }" class="mt-6">
    {{-- Encabezado del acordeón --}}
    <button @click="open = !open"
        class="flex items-center justify-between w-full text-sm font-semibold text-gray-800 dark:text-white mb-2 focus:outline-none">
        {{ __('Payments') }}
        <svg x-bind:class="{ 'rotate-180': open }"
            class="w-4 h-4 transition-transform duration-200 transform text-gray-500 dark:text-gray-300" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Contenido del acordeón --}}
    <div x-show="open" x-transition>
        @if ($payments->count())
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 mt-2">
                @foreach ($payments as $payment)
                    <x-memberships.payment-line :payment="$payment" :loop="$loop" />
                @endforeach
            </ul>

            {{-- Botón Ver más / Ver menos --}}
            @if ($payments->count() > 3)
                <div class="mt-3 text-right">
                    <button @click="showAll = !showAll"
                        class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                        <span x-show="!showAll">{{ __('View all payments') }}</span>
                        <span x-show="showAll">{{ __('Show less') }}</span>
                    </button>
                </div>
            @endif
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                {{ __('No payments registered yet.') }}
            </p>
        @endif
    </div>
</div>
