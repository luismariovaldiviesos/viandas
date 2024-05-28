<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Pagados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pedidos Pagados</h2>
        <p>Fecha de Pago: {{ \Carbon\Carbon::now()->format('d \\d\\e F \\d\\e\\l Y') }}</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Fecha Pedido</th>
                <th>Detalle</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendientes as $pendiente)
            <tr>
                <td>{{ $pendiente->cliente }}</td>
                <td>{{ $pendiente->telefono }}</td>
                <td>{{ $pendiente->mail }}</td>
                <td>{{ \Carbon\Carbon::parse($pendiente->fechapedido)->format('d \\d\\e F \\d\\e\\l Y') }}</td>
                <td>
                    @foreach ($pendiente->detalles as $detalle)
                        <p>{{ $detalle->menu->base }}</p>
                    @endforeach
                </td>
                <td>{{ $pendiente->total }}</td>
            @endforeach
        </tbody>
    </table>
</body>
</html>
