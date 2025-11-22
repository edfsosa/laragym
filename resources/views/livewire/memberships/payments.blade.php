<?php

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserMembership;
use App\Models\Payment;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

new #[Title('Pagos de Membresía')] class extends Component {
    use Toast;
    use WithPagination;

    #[Url]
    public string $search = '';

    public UserMembership $membership;

    /**
     * Limpia los filtros de búsqueda.
     */
    public function clear(): void
    {
        $this->search = '';
    }

    /**
     * Lista de pagos (status paid) de la membresía.
     */
    public function payments(): LengthAwarePaginator
    {
        return Payment::query()
            ->where('user_membership_id', $this->membership->id)
            ->where('status', 'paid')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('method', 'like', '%' . $this->search . '%')
                      ->orWhere('amount', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('paid_at', 'desc')
            ->paginate(10);
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
    <x-header title="{{ __('Payments for') }} {{ $membership->membership_name }}" separator progress-indicator />

    {{-- ACTIONS --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <x-button label="{{ __('Export') }}" icon="o-share" class="btn-primary" link="#" />
        <x-input placeholder="Search ..." wire:model.live.debounce="search" icon="o-magnifying-glass" />
    </div>

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
                'label' => $membership->membership_name,
                'link' => route('memberships.show', $membership),
            ],
            [
                'label' => __('Payments'),
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <!-- LISTA DE PAGOS -->
    <x-card shadow>
        @forelse($payments as $payment)
            <x-memberships.payment-list-item :payment="$payment" />
        @empty
            <x-alerts.no-results />
        @endforelse
    </x-card>
</div>
