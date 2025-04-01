<!DOCTYPE html>
<html>

    <style>
        .borde-cabecera{
            border: 1px solid black;
            padding: 10px;
        }

    </style>

    <body>
        <h1>Metodo de pago {{ $datos['tipo_pago'] }}</h1>

        <h3>Confirmacion de pago del pedido numero: {{$datos['idpedido']}}</h3>




        <table>
            <thead>
                <tr>
                    <th class="borde-cabecera">Nombre</th>
                    <th class="borde-cabecera">Stock Disponible</th>
                    <th class="borde-cabecera">Cantidad Vendida</th>
                    <th class="borde-cabecera">Precio Unitario</th>
                    <th class="borde-cabecera">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos['productos'] as $producto)
                <tr style="text-align: center;">
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->cantidad_vendido }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->precio * $producto->cantidad_vendido }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        @if($datos['costo_envio']>0)
        <h3>Costo envio: {{$datos['costo_envio']}}</h3>
        <hr>
        <h3>Total:  {{$datos['costo_envio']+$datos['costo_productos']}}</h3>
        @else
        <h3>Total:  {{$datos['costo_productos']}}</h3>
        @endif


    </body>
</html>