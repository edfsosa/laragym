<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Pagos - {{ $membership->membership_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-section {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .logo {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .logo h1 {
            font-size: 28px;
            color: #3b82f6;
            margin-bottom: 5px;
        }

        .logo p {
            color: #6b7280;
            font-size: 10px;
        }

        .document-info {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
        }

        .document-info h2 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .document-info p {
            color: #6b7280;
            font-size: 10px;
            margin-bottom: 3px;
        }

        /* Summary Section */
        .summary-section {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .summary-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 8px;
        }

        .summary-grid {
            display: table;
            width: 100%;
        }

        .summary-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
        }

        .summary-item-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .summary-item-value {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
        }

        /* Membership Info */
        .info-section {
            margin-bottom: 30px;
        }

        .info-grid {
            display: table;
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }

        .info-row {
            display: table-row;
        }

        .info-cell {
            display: table-cell;
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
            width: 50%;
        }

        .info-row:last-child .info-cell {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #4b5563;
            font-size: 10px;
        }

        .info-value {
            color: #1f2937;
            font-size: 11px;
        }

        /* Payments Table */
        .payments-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background: #3b82f6;
            color: white;
        }

        th {
            padding: 12px 10px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr:hover {
            background: #f3f4f6;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        /* Total Section */
        .total-section {
            margin-top: 20px;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 6px;
            text-align: right;
        }

        .total-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }

        .footer p {
            margin-bottom: 5px;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(59, 130, 246, 0.05);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>

<body>
    {{-- Watermark --}}
    <div class="watermark">LARAGYM</div>

    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="logo-section">
                <div class="logo">
                    <h1>🏋️ Laragym</h1>
                    <p>Tu centro de fitness de confianza</p>
                    <p style="margin-top: 5px;">
                        📧 info@laragym.com | 📱 +595 123 456 789<br>
                        📍 Asunción, Paraguay
                    </p>
                </div>
                <div class="document-info">
                    <h2>Resumen de Pagos</h2>
                    <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</p>
                    <p><strong>Usuario:</strong> {{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>

        {{-- Summary Statistics --}}
        <div class="summary-section">
            <div class="summary-title">📊 Resumen General</div>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-item-label">Total de Pagos</div>
                    <div class="summary-item-value">{{ $payments->count() }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-item-label">Monto Total</div>
                    <div class="summary-item-value" style="color: #10b981;">
                        ${{ number_format($totalAmount, 2) }}
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-item-label">Estado</div>
                    <div class="summary-item-value" style="color: #3b82f6;">
                        {{ $membership->status_label }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Membership Information --}}
        <div class="info-section">
            <div class="section-title">💳 Información de la Membresía</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Nombre de la Membresía</div>
                        <div class="info-value">{{ $membership->membership_name }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Estado</div>
                        <div class="info-value">
                            <span class="badge badge-success">{{ $membership->status_label }}</span>
                        </div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Fecha de Inicio</div>
                        <div class="info-value">{{ $membership->start_at_formatted }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Fecha de Fin</div>
                        <div class="info-value">{{ $membership->end_at_formatted }}</div>
                    </div>
                </div>
                @if ($membership->membership_description)
                    <div class="info-row">
                        <div class="info-cell" colspan="2" style="width: 100%;">
                            <div class="info-label">Descripción</div>
                            <div class="info-value">{{ $membership->membership_description }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Payments Table --}}
        <div class="payments-section">
            <div class="section-title">💰 Detalle de Pagos</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">#</th>
                        <th style="width: 20%;">Fecha</th>
                        <th style="width: 25%;">Método</th>
                        <th style="width: 27%;">ID Transacción</th>
                        <th style="width: 10%;" class="text-center">Estado</th>
                        <th style="width: 10%;" class="text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payment->paid_at_formatted }}</td>
                            <td>{{ $payment->method_label }}</td>
                            <td style="font-family: 'Courier New', monospace; font-size: 9px;">
                                {{ $payment->transaction_id ?? 'N/A' }}
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $payment->status_label }}</span>
                            </td>
                            <td class="text-right" style="font-weight: bold;">
                                {{ $payment->amount_formatted }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 30px; color: #9ca3af;">
                                No hay pagos registrados para esta membresía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Total Amount --}}
            @if ($payments->isNotEmpty())
                <div class="total-section">
                    <div class="total-label">TOTAL PAGADO</div>
                    <div class="total-amount">${{ number_format($totalAmount, 2) }}</div>
                </div>
            @endif
        </div>

        {{-- Additional Information --}}
        <div
            style="background: #fef3c7; padding: 15px; border-left: 4px solid #f59e0b; border-radius: 4px; margin-bottom: 20px;">
            <p style="margin: 0; color: #92400e; font-size: 10px;">
                <strong>ℹ️ Información Importante:</strong> Este documento es un resumen de todos los pagos realizados
                para la membresía "{{ $membership->membership_name }}".
                Para cualquier consulta o aclaración sobre los pagos, por favor contacte con nuestro equipo de soporte.
            </p>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p><strong>Laragym - Tu Centro de Fitness</strong></p>
            <p>Este documento ha sido generado automáticamente el {{ now()->format('d/m/Y') }} a las
                {{ now()->format('H:i') }}.</p>
            <p>Para consultas: info@laragym.com | Tel: +595 123 456 789</p>
            <p style="margin-top: 10px; color: #9ca3af;">
                © {{ now()->year }} Laragym. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>

</html>
