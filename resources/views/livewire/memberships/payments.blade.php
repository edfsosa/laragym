<?php

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserMembership;
use App\Models\Payment;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\Attributes\{Title, Url, Computed};
use Symfony\Component\HttpFoundation\StreamedResponse;

new #[Title('Historial de Pagos')] class extends Component {
    use Toast, WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public UserMembership $membership;

    /**
     * Limpia los filtros de búsqueda
     */
    public function clear(): void
    {
        $this->reset('search');
        $this->resetPage();
    }

    /**
     * Actualiza la paginación cuando cambia la búsqueda
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Lista de pagos de la membresía
     */
    #[Computed]
    public function payments(): LengthAwarePaginator
    {
        return Payment::query()
            ->where('user_membership_id', $this->membership->id)
            ->where('status', 'paid')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('method', 'like', '%' . $this->search . '%')
                        ->orWhere('amount', 'like', '%' . $this->search . '%')
                        ->orWhere('transaction_reference', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('paid_at', 'desc')
            ->paginate(10);
    }

    /**
     * Total de pagos realizados
     */
    #[Computed]
    public function totalPayments(): int
    {
        return $this->payments->total();
    }

    /**
     * Suma total de todos los pagos
     */
    #[Computed]
    public function totalAmount(): float
    {
        return Payment::query()->where('user_membership_id', $this->membership->id)->where('status', 'paid')->sum('amount');
    }

    /**
     * Descarga el recibo de un pago
     */
    public function downloadReceipt(int $id): StreamedResponse
    {
        $payment = Payment::with('userMembership')->findOrFail($id);

        // Verificar que el pago pertenece a la membresía actual
        if ($payment->user_membership_id !== $this->membership->id) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.payment-receipt', ['payment' => $payment]);

        $filename = "recibo_pago_{$payment->id}_" . now()->format('Y-m-d') . '.pdf';

        $this->success(__('Receipt downloaded successfully.'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $filename);
    }

    /**
     * Exporta todos los pagos a PDF
     */
    public function exportAllPayments(): StreamedResponse
    {
        $payments = Payment::query()->where('user_membership_id', $this->membership->id)->where('status', 'paid')->orderBy('paid_at', 'desc')->get();

        $pdf = Pdf::loadView('pdf.payments-summary', [
            'payments' => $payments,
            'membership' => $this->membership,
            'totalAmount' => $this->totalAmount,
        ]);

        $filename = "pagos_{$this->membership->membership_name}_" . now()->format('Y-m-d') . '.pdf';

        $this->success(__('Payments exported successfully.'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $filename);
    }
}; ?>

<div>
    {{-- HEADER --}}
    <x-header title="{{ __('Payment History') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button label="{{ __('Volver') }}" icon="o-arrow-left" link="{{ route('memberships.show', $membership) }}"
                class="btn-ghost btn-sm" responsive />
        </x-slot:actions>
    </x-header>

    {{-- BREADCRUMBS --}}
    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'icon' => 'o-home',
                'link' => route('dashboard'),
            ],
            [
                'label' => __('Memberships'),
                'icon' => 'o-identification',
                'link' => route('memberships.index'),
            ],
            [
                'label' => $membership->membership_name,
                'link' => route('memberships.show', $membership),
            ],
            [
                'label' => __('Payments'),
                'icon' => 'o-currency-dollar',
            ],
        ];
    @endphp

    <x-breadcrumbs :items="$breadcrumbs" class="mb-6" />

    {{-- ESTADÍSTICAS DE PAGOS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        {{-- Total de Pagos --}}
        <x-card shadow>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                    <x-icon name="o-document-text" class="w-6 h-6 text-primary" />
                </div>
                <div class="flex-1">
                    <p class="text-xs">
                        {{ __('Total Payments') }}
                    </p>
                    <p class="text-2xl font-bold">
                        {{ $this->totalPayments }}
                    </p>
                </div>
            </div>
        </x-card>

        {{-- Monto Total --}}
        <x-card shadow>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-success/10 flex items-center justify-center shrink-0">
                    <x-icon name="o-currency-dollar" class="w-6 h-6 text-success" />
                </div>
                <div class="flex-1">
                    <p class="text-xs">
                        {{ __('Total Amount') }}
                    </p>
                    <p class="text-2xl font-bold">
                        Gs. {{ $this->totalAmount, 2 }}
                    </p>
                </div>
            </div>
        </x-card>

        {{-- Estado de Membresía --}}
        <x-card shadow>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-info/10 flex items-center justify-center shrink-0">
                    <x-icon name="o-check-circle" class="w-6 h-6 text-info" />
                </div>
                <div class="flex-1">
                    <p class="text-xs">
                        {{ __('Status') }}
                    </p>
                    <p class="text-lg font-bold">
                        {{ $membership->status_label }}
                    </p>
                </div>
            </div>
        </x-card>
    </div>

    {{-- FILTROS Y ACCIONES --}}
    <div class="mb-6">
        <x-card shadow>
            <div class="flex flex-col md:flex-row gap-4 items-end">
                {{-- Búsqueda --}}
                <div class="flex-1">
                    <x-input wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search by method, amount or transaction ID...') }}"
                        icon="o-magnifying-glass" clearable>
                        <x-slot:label>
                            <span class="font-semibold">{{ __('Search') }}</span>
                        </x-slot:label>
                    </x-input>
                </div>

                {{-- Botones de acción --}}
                <div class="flex gap-2">
                    {{-- Exportar todos --}}
                    @if ($this->totalPayments > 0)
                        <x-button label="{{ __('Export All') }}" icon="o-arrow-down-tray"
                            wire:click="exportAllPayments" class="btn-primary" spinner />
                    @endif

                    {{-- Limpiar búsqueda --}}
                    @if ($search)
                        <x-button label="{{ __('Clear') }}" icon="o-x-mark" wire:click="clear" class="btn-ghost"
                            tooltip="{{ __('Clear search') }}" />
                    @endif
                </div>
            </div>

            {{-- Contador de resultados --}}
            @if ($this->totalPayments > 0)
                <div class="mt-4 pt-4 border-t border-base-200">
                    <div class="flex items-center gap-2 text-sm">
                        <x-icon name="o-check-badge" class="w-4 h-4" />
                        <span>
                            {{ __('Showing :count of :total payments', ['count' => $this->payments->count(), 'total' => $this->totalPayments]) }}
                        </span>
                    </div>
                </div>
            @endif
        </x-card>
    </div>

    {{-- LISTA DE PAGOS --}}
    <x-card title="{{ __('Payment Records') }}" shadow>
        @forelse($this->payments as $payment)
            <x-list-item :item="$payment" no-separator>
                {{-- Avatar con icono de método de pago --}}
                <x-slot:avatar>
                    <div class="w-12 h-12 rounded-lg bg-success/10 flex items-center justify-center shrink-0">
                        <x-icon name="o-credit-card" class="w-6 h-6 text-success" />
                    </div>
                </x-slot:avatar>

                {{-- Información principal --}}
                <x-slot:value>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-semibold">
                            {{ $payment->method_label }}
                        </span>
                        <x-badge value="{{ $payment->status_label }}" class="badge-success badge-sm" />
                    </div>
                </x-slot:value>

                {{-- Detalles --}}
                <x-slot:sub-value>
                    <div class="flex flex-col gap-1.5 text-sm mt-1">
                        {{-- Monto --}}
                        <div class="flex items-center gap-1.5">
                            <x-icon name="o-currency-dollar" label="{{ $payment->amount_formatted }}"
                                class="w-3.5 h-3.5" />
                        </div>

                        {{-- Fecha --}}
                        <div class="flex items-center gap-1.5">
                            <x-icon name="o-calendar" label="{{ $payment->paid_at_formatted }}" class="w-3.5 h-3.5" />
                        </div>

                        {{-- ID de transacción (si existe) --}}
                        @if ($payment->transaction_reference)
                            <div class="flex items-center gap-1.5">
                                <x-icon name="o-hashtag" label="{{ $payment->transaction_reference }}" class="w-3.5 h-3.5" />
                            </div>
                        @endif
                    </div>
                </x-slot:sub-value>

                {{-- Acción de descarga --}}
                <x-slot:actions>
                    <x-button icon="o-arrow-down-tray" wire:click="downloadReceipt({{ $payment->id }})"
                        class="btn-sm" tooltip="{{ __('Download receipt') }}" spinner />
                </x-slot:actions>
            </x-list-item>
        @empty
            {{-- Estado vacío --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                {{-- Icono --}}
                <div class="w-24 h-24 rounded-full bg-base-200 flex items-center justify-center mb-6">
                    <x-icon name="{{ $search ? 'o-magnifying-glass' : 'o-document-text' }}"
                        class="w-12 h-12" />
                </div>

                {{-- Título --}}
                <h3 class="text-xl font-bold mb-2">
                    @if ($search)
                        {{ __('No payments found') }}
                    @else
                        {{ __('No payments yet') }}
                    @endif
                </h3>

                {{-- Descripción --}}
                <p class="text-sm mb-6 max-w-md">
                    @if ($search)
                        {{ __('No payment records match your search criteria. Please try different keywords.') }}
                    @else
                        {{ __('There are no payment records for this membership yet. Payments will appear here once processed.') }}
                    @endif
                </p>

                {{-- Acciones --}}
                <div class="flex gap-3">
                    @if ($search)
                        <x-button label="{{ __('Clear search') }}" wire:click="clear" icon="o-x-mark"
                            class="btn-primary" />
                    @endif

                    <x-button label="{{ __('Back to Membership') }}" icon="o-arrow-left"
                        link="{{ route('memberships.show', $membership) }}" class="btn-ghost" />
                </div>
            </div>
        @endforelse
    </x-card>

    {{-- PAGINACIÓN --}}
    @if ($this->payments->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $this->payments->links() }}
        </div>
    @endif

    {{-- INFORMACIÓN ADICIONAL --}}
    @if ($this->totalPayments > 0)
        <div class="mt-8">
            <x-card shadow>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-info/10 flex items-center justify-center shrink-0">
                        <x-icon name="o-information-circle" class="w-6 h-6 text-info" />
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">
                            {{ __('Need a specific receipt?') }}
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Click the download button next to any payment to get your receipt. You can also export all payments at once using the Export All button.') }}
                        </p>
                    </div>
                </div>
            </x-card>
        </div>
    @endif
</div>
