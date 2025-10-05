<?php

namespace App\Livewire;

use Livewire\Component;

class MemberMemberships extends Component
{
    public $showReceiptModal = false;
    public $selectedReceipt = null;

    public function viewReceipt($index)
    {
        $payments = $this->getPayments();
        $this->selectedReceipt = $payments[$index] ?? null;
        $this->showReceiptModal = true;
    }

    public function closeReceiptModal()
    {
        $this->showReceiptModal = false;
        $this->selectedReceipt = null;
    }

    private function getPayments()
    {
        return [
            (object) [
                'date' => '15/01/2025',
                'amount' => 'Gs. 150,000',
                'method' => 'Transferencia',
                'status' => 'paid',
                'reference' => 'TXN123456',
            ],
            (object) [
                'date' => '15/02/2025',
                'amount' => 'Gs. 150,000',
                'method' => 'Efectivo',
                'status' => 'pending',
                'reference' => 'TXN789012',
            ],
        ];
    }

    public function render()
    {
        $memberships = collect([
            (object) [
                'name' => 'Monthly Basic Plan',
                'price' => 'Gs. 150,000',
                'status' => 'active',
                'start_date' => '15/01/2025',
                'end_date' => null,
            ],
            (object) [
                'name' => 'Annual Basic Plan',
                'price' => 'Gs. 1,500,000',
                'status' => 'cancelled',
                'start_date' => '01/01/2024',
                'end_date' => '31/12/2024',
            ],
        ]);

        return view('livewire.member-memberships', [
            'memberships' => $memberships,
            'payments' => collect($this->getPayments()),
        ]);
        
    }
}
