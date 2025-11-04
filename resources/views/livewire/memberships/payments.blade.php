<?php

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserMembership;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

new #[Title('Payments')] class extends Component {
    use Toast;

    public UserMembership $membership;

    public function payments(): Collection
    {
        return $this->membership->payments()->latest()->get();
    }

    public function downloadReceipt(int $id): StreamedResponse
    {
        $payment = Payment::with('userMembership')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.payment-receipt', ['payment' => $payment]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "recibo_pago_{$payment->id}.pdf");
    }

    public function with(): array
    {
        return [
            'payments' => $this->payments(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Payments for') }} {{ $membership->membership_name }}"
    separator progress-indicator />

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => '/dashboard',
            ],
            [
                'label' => __('Memberships'),
                'link' => '/memberships',
            ],
            [
                'label' => __('Payments'),
                'link' => '#',
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <x-card shadow>
        @forelse($payments as $payment)
            <x-list-item :item="$payment">
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
                        @if ($payment->paid_at)
                            <p>
                                {{ $payment->paid_at_formatted }}
                            </p>
                        @endif
                    </div>
                </x-slot:sub-value>
                <x-slot:actions>
                    <x-button icon="o-arrow-down" class="btn-sm" wire:click="downloadReceipt({{ $payment->id }})"
                        wire:loading.attr="disabled" spinner />
                </x-slot:actions>
            </x-list-item>
        @empty
            <p>{{ __('No payments found for this membership.') }}</p>
        @endforelse
    </x-card>
</div>
