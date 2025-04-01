<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="{{ asset('js/mi.js') }}"></script>
    @include('components.header')

    <main class="container-gestor">


        <h1>Carrito de la compra</h1>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <br>
        @elseif(session('failed'))
        <div class="alert alert-warning">
            {{ session('failed') }}
        </div>
        <br>
        @endif




        @if(count($carrito) > 0)
        <table>
            <tr>
                <th class="th-mobile">Imagen</th>
                <th class="th-mobile">Nombre</th>
                <th class="th-mobile">Precio</th>
                <th class="th-mobile">Unidades</th>
                <th class="th-mobile">Eliminar</th>
            </tr>

            @foreach ($carrito as $indice => $elemento)
            <tr>
                <td>
                    @if (!empty($elemento['producto']['imagen']))
                    <img src="{{ asset('storage/' . $elemento['producto']['imagen']) }}" class="img_carrito" />
                    @else
                    <img src="{{ asset('img/camiseta.png') }}" class="img_carrito" />
                    @endif
                </td>
                <td class="th-mobile">{{ $elemento['producto']['nombre'] }}</td>
                <td class="th-mobile">$ {{ $elemento['precio'] }}</td>
                <td style=" position: relative; top: 25px;">
                    {{ $elemento['unidades'] }}
                    <div class="updown-unidades">
                        <a href="{{ route('carrito.incrementar', $indice) }}" class="button">+</a>
                        <a href="{{ route('carrito.decrementar', $indice) }}" class="button">-</a>
                    </div>
                </td>
                <td class="th-mobile">
                    <a style="font-size: 12px;" href="{{ route('carrito.eliminar', $indice) }}" class="button button-carrito button-red">Eliminar</a>
                </td>
            </tr>
            @endforeach
        </table>

        <br/>
        <div  class="delete-carrito">
            <a style="width: auto;" href="{{ route('carrito.vaciar') }}" class="button button-delete button-red">Vaciar carrito</a>
        </div>
        <div style="width: auto;" class="total-carrito">
            <h3 class="precio-total-carrito">Total: $ {{ number_format(array_sum(array_map(fn($item) => $item['precio'] * $item['unidades'], $carrito)), 2, ',', '.') }}</h3>
            <a  href="{{ route('pedido.realizar') }}" class="button button-pedido">Hacer pedido</a>
        </div>
        @else
        <p>El carrito está vacío, añade algún producto.</p>
        @endif


    </main>


    @include('components.footer')