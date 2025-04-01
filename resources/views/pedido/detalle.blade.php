<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="{{ asset('js/mi.js') }}"></script>

    @include('components.header')

    <main class="container-gestor">

        <br>
        <h1>Detalle del pedido</h1>
        <hr>
        @if ($pedido)
        <h3>Estado del pedido</h3>
        <div style="margin-right: 0px;" class="row">
            <div class="col-md-6">

                @if($pago->tipo_pago!='mercadopago' && Auth::user()->rol === 'admin')
                <form action="{{ route('pedidos.updateEstado') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $pedido->id }}" name="pedido_id"/>
                    <select class="input-log" name="estado">
                        <option style="color: blue" value="confirm" title="aun no seleccion metodo de pago" {{ $pedido->estado == "confirm" ? 'selected' : '' }}>Pendiente</option>
                        <option style="color: orange" value="esperandoConfirmacion" title="metodo de pago seleccionado, falta recibir confirmacion" {{ $pedido->estado == "esperandoConfirmacion" ? 'selected' : '' }}>Pago pendiente</option>
                        <option style="color: green" value="pagado" {{ $pedido->estado == "pagado" ? 'selected' : '' }}>Pago confirmado</option>
                        <option style="color: red" value="cancelado" {{ $pedido->estado == "cancelado" ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    <input type="submit" value="Cambiar estado"/>
                </form>
                @else
                @switch($pedido->estado)
                @case('confirm')               
                <h6 style="text-transform: capitalize; color: blue; font-weight: bold;">Confirmado</h6>
                @break  
                @case('esperandoConfirmacion')               
                <h6 style="text-transform: capitalize; color: orange; font-weight: bold;">Pago pendiente</h6>
                @break
                @case('pagado')               
                <h6 style="text-transform: capitalize; color: green; font-weight: bold;">{{$pedido->estado}}</h6>
                @break
                @case('cancelado')               
                <h6 style="text-transform: capitalize; color: red; font-weight: bold;">{{$pedido->estado}}</h6>
                @break


                @endswitch
                @endif
            </div>
            <div class="col-md-6">
                {{-- vamos a mostrar el boton de pago de mercadopago si fue generado el link previamente y el estado es diferente a pagado --}}
                @if(isset($pago->init_point_mercadopago) && $pedido->estado=='esperandoConfirmacion')
                <a href="{{ $pago->init_point_mercadopago }}" target="_blank" class="btn btn-primary">
                    <img style="width: 90px; border-radius: 50px;" src="{{asset('img/images.png')}}" alt="Mercado Pago" > 
                    Pagar Mercado Pago
                </a>
                @endif
            </div>
        </div>
        <br/>
        <br>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <br>
        <br>
        @elseif(session('failed'))
        <div class="alert alert-failed">
            {{ session('failed') }}
        </div>
        <br>
        <br>
        @endif

        <div style="display: flex;">
            <div class="txt-detalle-datos" style="width: 50%;">
                <h3 class="h3-detalle-pedido">Datos del cliente</h3>
                Nombre: {{ $pedido->usuario->name }} <br/>
                Apellido: {{ $pedido->usuario->surname }} <br/>
                Email: {{ $pedido->usuario->email }} <br/><br/>

                <h3 class="h3-detalle-pedido">Datos del receptor</h3>
                Nombre receptor: {{ $envio->nombre_receptor }} <br/>
                DNI receptor: {{ $envio->dni_receptor }} <br/>
                Telefono: {{ $envio->telefono }} <br/><br/>

            </div>
            <div class="txt-detalle-datos" style="width: 50%;">   
                @if($envio["tipo_envio"]!='coordinarEnvio')
                <h3 class="h3-detalle-pedido">Dirección de envío</h3>
                Provincia: {{ $envio->provincia }} <br/>
                Ciudad: {{ $envio->localidad }} <br/>
                Dirección: {{ $envio->direccion }} <br/><br/>
                @endif

                <h3 class="h3-detalle-pedido">Datos del pedido:</h3>

                @switch($envio->tipo_envio)
                @case('coordinarEnvio')
                <span style="font-weight: bold;">Tipo envio:</span>  a coordinar con cliente<br/>
                @break

                @case('envioSucursal')
                <span style="font-weight: bold;">Tipo envio:</span> envio a sucursal <br/>
                @break

                @case('envioDomicilio')
                <span style="font-weight: bold;">Tipo envio:</span> envio a domicilio <br/>
                @break
                @endswitch

                @if($envio["tipo_envio"]!='coordinarEnvio')
                Estado: {{ $envio->estado }} <br/>
                @endif
                Número de pedido: {{ $pedido->id }} <br/><br/>
                <span style="font-weight: bold;">Total a pagar: </span> {{ $pedido->costo_productos + $pedido->costo_envio }} $ <br/>

            </div>

        </div>
        @if($pago->tipo_pago!='mercadopago')
        <p class="txt-transferencia"  style="font-weight: bold;">Recorda enviarnos el comprobante de la transferencia a asadsa@gmail.com</p>
        @endif
        Productos 
        <br>
        <table>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Unidades</th>
            </tr>
            @foreach ($pedido->productos as $producto)
            <tr>
                <td>
                    @if ($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="img_carrito"/>
                    @else
                    <img src="{{ asset('img/camiseta.png') }}" class="img_carrito"/>
                    @endif
                </td>
                <td>
                    <a href="{{ route('producto.ver', $producto->id) }}">{{ $producto->nombre }}</a>
                </td>
                <td>{{ $producto->precio }}</td>
                <td>{{ $producto->pivot->unidades }}</td>
            </tr>
            @endforeach
        </table>
        @endif


    </main>


    @include('components.footer')
