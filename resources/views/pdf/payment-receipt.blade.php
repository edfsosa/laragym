<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Recibo de Pago</h2>
        <p>ID de pago: {{ $payment->id }}</p>
    </div>

    <table class="table">
        <tr>
            <th>Fecha de pago</th>
            <td>{{ $payment->paid_at_formatted }}</td>
        </tr>
        <tr>
            <th>Monto</th>
            <td>{{ $payment->amount_formatted }}</td>
        </tr>
        <tr>
            <th>Estado</th>
            <td>{{ $payment->status_label }}</td>
        </tr>
        <tr>
            <th>Método</th>
            <td>{{ $payment->method_label }}</td>
        </tr>
        <tr>
            <th>Referencia</th>
            <td>{{ $payment->transaction_reference ?? '-' }}</td>
        </tr>
        <tr>
            <th>Membresía</th>
            <td>{{ $payment->membership_name }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">Gracias por su pago.</p>
</body>

</html>
