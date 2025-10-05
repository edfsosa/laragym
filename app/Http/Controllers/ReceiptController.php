<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function download($reference)
    {
        // Simulación de búsqueda del recibo por referencia
        $receipt = collect([
            'TXN123456' => [
                'date' => '15/01/2025',
                'amount' => 'Gs. 150,000',
                'method' => 'Transferencia',
                'status' => 'paid',
                'reference' => 'TXN123456',
            ],
            'TXN789012' => [
                'date' => '15/02/2025',
                'amount' => 'Gs. 150,000',
                'method' => 'Efectivo',
                'status' => 'pending',
                'reference' => 'TXN789012',
            ],
        ])->get($reference);

        if (! $receipt) {
            abort(404);
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('receipt'));

        return $pdf->stream('receipt_'.$reference.'.pdf');
    }
}
