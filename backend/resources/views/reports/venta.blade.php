<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #fff;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        #header div{
            vertical-align: top;
            display: inline-block;
            width: 45%;
            
        }
        .header .title {
            text-align: left;
            font-size: 24px;
            font-weight: bold;
            width: 40%; 
        }
        
        .logo{
            text-align: right ;
        }
        .header .logo img {
            width: 100px;
            
        }
        .invoice-info {
            margin-bottom: 20px;
        }
        .invoice-info h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .invoice-info p {
            margin: 5px 0;
        }
        .details {
            margin-bottom: 20px;
        }
        .details h2 {
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 2px solid #007BFF;
            display: inline-block;
        }
        .details p {
            margin: 5px 0;
        }
        .details p strong {
            display: inline-block;
            width: 100px;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items th, .items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }
        .items th {
            background-color: #007BFF;
            color: white;
        }
        .totals {
            width: 50%;
            margin-left: 50%;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f8f8f8;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals th, .totals td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }
        .totals th {
            background-color: #f1f1f1;
        }
        .totals tr:last-child th, .totals tr:last-child td {
            border-bottom: none;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer p {
            margin: 0;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 18px;
        }
        .footer .contact {
            margin-top: 10px;
        }
        .footer .contact div {
            display: inline-block;
            width: 45%;
            vertical-align: top;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" id="header">
            <div class="title"><h2></h2>{{$venta->tipo==='B'?'BOLETA':'FACTURA'}}</div>
            <div class="logo">
                <img src="../resources/image/casa_micas.png" alt="Logo">
            </div>
        </div>
        <div class="invoice-info">
            <h2>{{ $venta->sucursal->nombre }}</h2>
            <p><strong>{{$venta->tipo==='B'?'Boleta':'Factura'}} n.°:</strong> {{ $venta->tipo==='B'? $venta->boleta[0]->serie." - ".$venta->boleta[0]->correlativo :$venta->factura[0]->serie." - ".$venta->factura[0]->correlativo }}</p>
            <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="details">
            <div>
                <h2>{{$venta->cliente->nombre." ".$venta->cliente->apePaterno." ".$venta->cliente->apeMaterno  }}</h2>
                <p><strong>DNI:</strong>{{$venta->cliente->dni }}</p>
            </div>
        </div>
        <table class="items">
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->venta_inventarios as $index => $item)
                    <tr>
                        <td>{{ $item->inventario->articulo->nombre }}</td>
                        <td>{{ number_format($item->cantidad, 2) }}</td>
                        <td>{{ number_format($item->precio, 2) }}</td>
                        <td>{{ number_format($item->cantidad * $item->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="totals">
            <table>
                <tr>
                    <th>Subtotal:</th>
                    <td>{{ number_format($venta->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <th>Impuestos (0%):</th>
                    <td>{{ number_format($venta->impuestos, 2) }}</td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td>{{ number_format($venta->total, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>¡Gracias por su compra!</p>
            <div class="contact">
                <div>
                    <h2>Información de pago</h2>
                    <p>{{$venta->cliente->nombre." ".$venta->cliente->apePaterno." ".$venta->cliente->apeMaterno  }}</p>
                    <p>vendedor: {{$venta->user->nombre}}</p>
                    <p>Cuenta: S/N</p>
                    
                </div>
                <div>
                    <h2>Contacto</h2>
                    <p>Teléfono: {{$venta->sucursal->telefono}}</p>
                    <p>Dirección: {{$venta->sucursal->direccion}}</p>
                    <p>www.lacasademicas.com</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
