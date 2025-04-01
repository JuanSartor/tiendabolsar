<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.header')

    <main class="container-gestor">

        @if( Auth::user()->rol === 'admin')
        <h1>Gestionar pedidos</h1>
        @else
        <h1>Mis pedidos</h1>
        @endif

        <div class="col-md-6 d-flex align-items-center">
            @if(Route::is('pedido.gestion'))
            <form method="GET" action="{{ route('pedido.gestion') }}">
                <div>
                    <input style="width: 280px;" type="text" name="search" placeholder="Buscar pedido por id..." value="{{ request('search') }}">
                </div>
                <div>
                    <button type="submit">Buscar</button>
                </div>
            </form>
            @else
            <form method="GET" action="{{ route('pedido.mispedidos') }}">
                <div>
                    <input style="width: 280px;" type="text" name="search" placeholder="Buscar pedido por id..." value="{{ request('search') }}">
                </div>
                <div>
                    <button type="submit">Buscar</button>
                </div>
            </form>
            @endif
        </div>

        <table>
            <tr>
                <th>Nº Pedido</th>
                <th>Costo</th>         
                <th>Estado</th>
            </tr>
            @foreach ($pedidos as $pedido)
            <tr>
                <td>
                    <a href="{{ route('pedido.detalle', $pedido->id) }}">{{ $pedido->id }}</a>
                </td>
                <td>
                    $ {{ number_format($pedido->costo_envio + $pedido->costo_productos, 2, ',', '.') }} 
                </td>


                <td>
                    @php
                    $estado = $pedido->mostrarEstado($pedido->estado); 
                    @endphp
                    @switch($estado)
                    @case('Confirmado')
                    <span class="badge bg-warning">{{$estado}}</span>
                    @break

                    @case('Pago pendiente')
                    <span class="badge bg-info">{{$estado}}</span>
                    @break

                    @case('Pagado')
                    <span class="badge bg-success">{{$estado}}</span>
                    @break

                    @default
                    <span class="badge bg-danger">{{$estado}}</span>
                    @endswitch
                </td>
            </tr>
            @endforeach
        </table>

        <div class="pagination-container">
            {{ $pedidos->onEachSide(0)->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </main>


    @include('components.footer')
