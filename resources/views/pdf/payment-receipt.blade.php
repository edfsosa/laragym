<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago #{{ $payment->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
            line-height: 1.6;
            padding: 30px;
            background: #f9fafb;
        }

        .receipt-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .receipt-header {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 3px solid #3b82f6;
            margin-bottom: 30px;
        }

        .receipt-header h1 {
            font-size: 32px;
            color: #3b82f6;
            margin-bottom: 5px;
        }

        .receipt-header .tagline {
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 15px;
        }

        .receipt-title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin: 20px 0 10px 0;
        }

        .receipt-number {
            font-size: 14px;
            color: #6b7280;
            font-family: 'Courier New', monospace;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 10px;
            background: #d1fae5;
            color: #065f46;
        }

        /* Info Sections */
        .info-section {
            margin-bottom: 30px;
        }

        .info-section-title {
            font-size: 12px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-cell {
            display: table-cell;
            padding: 10px 0;
            vertical-align: top;
        }

        .info-label {
            font-weight: 600;
            color: #4b5563;
            font-size: 11px;
            width: 40%;
        }

        .info-value {
            color: #1f2937;
            font-size: 11px;
        }

        /* Payment Details Box */
        .payment-details {
            background: #f3f4f6;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }

        .payment-amount-section {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px dashed #d1d5db;
            margin-bottom: 20px;
        }

        .payment-amount-label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .payment-amount {
            font-size: 48px;
            font-weight: bold;
            color: #10b981;
            line-height: 1;
        }

        .payment-currency {
            font-size: 24px;
            vertical-align: top;
        }

        /* Transaction Details */
        .transaction-grid {
            display: table;
            width: 100%;
        }

        .transaction-row {
            display: table-row;
        }

        .transaction-cell {
            display: table-cell;
            padding: 8px 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .transaction-row:last-child .transaction-cell {
            border-bottom: none;
        }

        .transaction-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 10px;
            width: 50%;
        }

        .transaction-value {
            color: #1f2937;
            font-size: 11px;
            text-align: right;
        }

        /* Membership Details */
        .membership-box {
            background: #eff6ff;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .membership-box-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 15px;
        }

        .membership-details {
            display: table;
            width: 100%;
        }

        .membership-row {
            display: table-row;
        }

        .membership-cell {
            display: table-cell;
            padding: 6px 0;
        }

        .membership-label {
            font-size: 10px;
            color: #3b82f6;
            font-weight: 600;
            width: 35%;
        }

        .membership-value {
            font-size: 11px;
            color: #1e40af;
        }

        /* Thank You Section */
        .thank-you-section {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 0;
        }

        .thank-you-section h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .thank-you-section p {
            font-size: 11px;
            opacity: 0.9;
        }

        /* Footer */
        .receipt-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
        }

        .contact-info {
            margin-bottom: 15px;
        }

        .contact-info p {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .contact-info .icon {
            display: inline-block;
            width: 16px;
        }

        .legal-text {
            font-size: 9px;
            color: #9ca3af;
            margin-top: 15px;
            line-height: 1.5;
        }

        /* QR Code Placeholder */
        .qr-section {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: white;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
        }

        .qr-placeholder {
            width: 120px;
            height: 120px;
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            margin: 0 auto 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #9ca3af;
        }

        /* Verification Code */
        .verification-code {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
        }

        .verification-code-label {
            font-size: 10px;
            color: #92400e;
            margin-bottom: 5px;
        }

        .verification-code-value {
            font-size: 16px;
            font-weight: bold;
            color: #78350f;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }

        /* Stamps */
        .stamp {
            position: absolute;
            top: 100px;
            right: 50px;
            transform: rotate(-15deg);
            border: 3px solid #10b981;
            color: #10b981;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            opacity: 0.3;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        {{-- Paid Stamp --}}
        <div class="stamp">PAGADO</div>

        {{-- Header --}}
        <div class="receipt-header">
            <h1>🏋️ Laragym</h1>
            <p class="tagline">Tu centro de fitness de confianza</p>
            <div class="receipt-title">Recibo de Pago</div>
            <div class="receipt-number">#{{ str_pad($payment->id, 8, '0', STR_PAD_LEFT) }}</div>
            <span class="status-badge">✓ {{ $payment->status_label }}</span>
        </div>

        {{-- Payment Amount - Destacado --}}
        <div class="payment-details">
            <div class="payment-amount-section">
                <div class="payment-amount-label">Monto Pagado</div>
                <div class="payment-amount">
                    <span class="payment-currency">$</span>{{ number_format($payment->amount, 2) }}
                </div>
            </div>

            {{-- Transaction Details --}}
            <div class="transaction-grid">
                <div class="transaction-row">
                    <div class="transaction-cell transaction-label">Método de Pago:</div>
                    <div class="transaction-cell transaction-value">{{ $payment->method_label }}</div>
                </div>
                <div class="transaction-row">
                    <div class="transaction-cell transaction-label">Fecha de Pago:</div>
                    <div class="transaction-cell transaction-value">{{ $payment->paid_at_formatted }}</div>
                </div>
                @if ($payment->transaction_id)
                    <div class="transaction-row">
                        <div class="transaction-cell transaction-label">ID de Transacción:</div>
                        <div class="transaction-cell transaction-value"
                            style="font-family: 'Courier New', monospace; font-size: 10px;">
                            {{ $payment->transaction_id }}
                        </div>
                    </div>
                @endif
                <div class="transaction-row">
                    <div class="transaction-cell transaction-label">Fecha de Emisión:</div>
                    <div class="transaction-cell transaction-value">{{ now()->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        {{-- Customer Information --}}
        <div class="info-section">
            <div class="info-section-title">👤 Información del Cliente</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell info-label">Nombre:</div>
                    <div class="info-cell info-value">{{ $payment->userMembership->user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-cell info-label">Email:</div>
                    <div class="info-cell info-value">{{ $payment->userMembership->user->email }}</div>
                </div>
                @if ($payment->userMembership->user->phone)
                    <div class="info-row">
                        <div class="info-cell info-label">Teléfono:</div>
                        <div class="info-cell info-value">{{ $payment->userMembership->user->phone }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Membership Information --}}
        <div class="membership-box">
            <div class="membership-box-title">💳 Detalles de la Membresía</div>
            <div class="membership-details">
                <div class="membership-row">
                    <div class="membership-cell membership-label">Membresía:</div>
                    <div class="membership-cell membership-value">{{ $payment->userMembership->membership_name }}</div>
                </div>
                <div class="membership-row">
                    <div class="membership-cell membership-label">Estado:</div>
                    <div class="membership-cell membership-value">{{ $payment->userMembership->status_label }}</div>
                </div>
                <div class="membership-row">
                    <div class="membership-cell membership-label">Fecha de Inicio:</div>
                    <div class="membership-cell membership-value">{{ $payment->userMembership->start_at_formatted }}
                    </div>
                </div>
                <div class="membership-row">
                    <div class="membership-cell membership-label">Fecha de Fin:</div>
                    <div class="membership-cell membership-value">{{ $payment->userMembership->end_at_formatted }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Verification Code --}}
        <div class="verification-code">
            <div class="verification-code-label">Código de Verificación</div>
            <div class="verification-code-value">
                {{ strtoupper(substr(md5($payment->id . $payment->created_at), 0, 12)) }}
            </div>
        </div>

        {{-- QR Code Section (Placeholder) --}}
        <div class="qr-section">
            <div class="qr-placeholder">
                [QR Code]<br>
                Verificación
            </div>
            <p style="font-size: 9px; color: #6b7280;">
                Escanea este código para verificar la autenticidad del recibo
            </p>
        </div>

        {{-- Thank You Section --}}
        <div class="thank-you-section">
            <h3>¡Gracias por tu pago! 💪</h3>
            <p>Apreciamos tu confianza en Laragym. Tu pago nos permite seguir ofreciéndote el mejor servicio.</p>
        </div>

        {{-- Additional Notes --}}
        @if ($payment->notes)
            <div
                style="background: #f9fafb; padding: 15px; border-left: 4px solid #3b82f6; border-radius: 4px; margin: 20px 0;">
                <strong style="font-size: 11px; color: #1f2937;">Notas:</strong>
                <p style="font-size: 10px; color: #4b5563; margin-top: 5px;">{{ $payment->notes }}</p>
            </div>
        @endif

        {{-- Footer --}}
        <div class="receipt-footer">
            <div class="contact-info">
                <p><span class="icon">📧</span> info@laragym.com</p>
                <p><span class="icon">📱</span> +595 123 456 789</p>
                <p><span class="icon">📍</span> Asunción, Paraguay</p>
                <p><span class="icon">🌐</span> www.laragym.com</p>
            </div>

            <div class="legal-text">
                <p>
                    <strong>TÉRMINOS Y CONDICIONES:</strong> Este recibo es un comprobante oficial de pago.
                    Conserve este documento para sus registros. Para cualquier consulta o reclamo,
                    por favor contacte con nuestro equipo de soporte citando el número de recibo.
                </p>
                <p style="margin-top: 10px;">
                    <strong>Laragym © {{ now()->year }}</strong> - Todos los derechos reservados.
                    RUC: 80012345-6 | Documento generado el {{ now()->format('d/m/Y') }} a las
                    {{ now()->format('H:i') }}
                </p>
            </div>
        </div>
    </div>
</body>

</html>
