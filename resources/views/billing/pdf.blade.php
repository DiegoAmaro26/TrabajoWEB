<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 40px;
            color: #333;
        }

        .header {
            overflow: hidden;
            margin-bottom: 20px;
        }

        .header img {
            height: 60px;
            float: left;
            margin-right: 20px;
        }

        .header .info {
            float: left;
        }

        h2, h3, h4 {
            margin-bottom: 5px;
            color: #1a202c;
        }

        p {
            margin: 2px 0;
        }

        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #999;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
        }

        .section-title {
            background-color: #f1f5f9;
            padding: 6px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    {{-- Header con logo y datos del hospital --}}
    <div class="header">
        <img src="{{ public_path('images/logo.jpg') }}" alt="Logo">
        <div class="info">
            <h2>{{ $invoice->client->hospital->name ?? 'Hospital Veterinario' }}</h2>
            <p>Dirección: Calle Principal 123, Ciudad</p>
            <p>Teléfono: 123 456 789</p>
        </div>
    </div>

    <hr>

    <h3>Factura #{{ $invoice->id }}</h3>
    <p><strong>Cliente:</strong> {{ $invoice->client->full_name }}</p>
    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($invoice->billing_date)->format('d/m/Y') }}</p>

    <h4 class="section-title">Productos</h4>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario (€)</th>
                <th>Subtotal (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                    <td>{{ number_format($product->pivot->price * $product->pivot->quantity, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="section-title">Servicios</h4>
    <table>
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Precio (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ number_format($service->pivot->price, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total: {{ number_format($invoice->total, 2, ',', '.') }} €</p>
    <p><strong>Método de pago:</strong> {{ ucfirst($invoice->payment_method) }}</p>

    <hr>

    <div class="footer">
        <p>Gracias por confiar en nuestro hospital veterinario.</p>
    </div>

</body>
</html>
