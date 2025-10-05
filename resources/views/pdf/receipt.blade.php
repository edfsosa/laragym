<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago - {{ $receipt['reference'] }}</title>
    <style>
        @page {
            margin: 30px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 0;
            padding: 0;
        }

        .header {
            border-bottom: 2px solid #6366f1;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .logo {
            float: left;
        }

        .gym-info {
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .receipt-title {
            color: #1e1e2f;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            color: #4f46e5;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }

        .details {
            width: 100%;
            border-collapse: collapse;
        }

        .details td {
            padding: 6px 0;
        }

        .details strong {
            color: #111827;
        }

        .amount-box {
            background-color: #eef2ff;
            border: 1px solid #c7d2fe;
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            color: #3730a3;
        }

        .footer {
            border-top: 1px solid #ddd;
            margin-top: 30px;
            padding-top: 10px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
        }

        .status {
            padding: 3px 10px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status-paid {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background-color: #fef9c3;
            color: #92400e;
        }
    </style>
</head>

<body>
    {{-- 🔹 Encabezado --}}
    <div class="header">
        <div class="logo">
            {{-- Si querés, reemplazá con la ruta a tu logo --}}
            <img src="https://png.pngtree.com/png-vector/20191018/ourmid/pngtree-gym-logo-png-image_1824195.jpg" alt="Larafit" width="90">
        </div>
        <div class="gym-info">
            <h3><strong>LARAFIT GYM</strong></h3>
            <p style="margin:0;">Av. España 1234 - Asunción</p>
            <p style="margin:0;">Tel: (021) 555-555</p>
            <p style="margin:0;">Email: info@larafit.com</p>
        </div>
        <div class="clear"></div>
    </div>

    {{-- 🔹 Título --}}
    <div class="receipt-title">Recibo de Pago</div>

    {{-- 🔹 Datos del cliente (simulado) --}}
    <div class="section">
        <div class="section-title">Datos del Miembro</div>
        <table class="details" width="100%">
            <tr>
                <td><strong>Nombre:</strong> Juan Pérez</td>
                <td><strong>Membresía:</strong> Plan Mensual Básico</td>
            </tr>
            <tr>
                <td><strong>Documento:</strong> 4.567.890</td>
                <td><strong>Referencia:</strong> {{ $receipt['reference'] }}</td>
            </tr>
        </table>
    </div>

    {{-- 🔹 Detalle del pago --}}
    <div class="section">
        <div class="section-title">Detalles del Pago</div>
        <table class="details" width="100%">
            <tr>
                <td><strong>Fecha:</strong> {{ $receipt['date'] }}</td>
                <td><strong>Método:</strong> {{ $receipt['method'] }}</td>
            </tr>
            <tr>
                <td><strong>Estado:</strong>
                    <span class="status {{ $receipt['status'] === 'paid' ? 'status-paid' : 'status-pending' }}">
                        {{ ucfirst($receipt['status']) }}
                    </span>
                </td>
                <td><strong>Monto:</strong> {{ $receipt['amount'] }}</td>
            </tr>
        </table>
    </div>

    {{-- 🔹 Monto destacado --}}
    <div class="amount-box">
        Total abonado: {{ $receipt['amount'] }}
    </div>

    {{-- 🔹 Observaciones --}}
    <div class="section" style="margin-top: 25px;">
        <div class="section-title">Observaciones</div>
        <p style="margin:0; color:#4b5563;">
            Gracias por tu pago. Recordá que podés consultar tus próximas cuotas o historial
            de pagos desde tu cuenta en <strong>Larafit</strong>.
        </p>
    </div>

    {{-- 🔹 Pie de página --}}
    <div class="footer">
        Documento generado automáticamente por el sistema Larafit - {{ date('d/m/Y H:i') }}<br>
        © {{ date('Y') }} Larafit Gym. Todos los derechos reservados.
    </div>
</body>

</html>
