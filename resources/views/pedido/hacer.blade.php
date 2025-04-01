<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="{{ asset('js/mi.js') }}"></script>

    @include('components.header')

    <main class="container-gestor">

        @if (Auth::check())
        <h1>Detalles de envio</h1>
        <p>
            <a href="{{ route('carrito.index') }}">Ver los productos y el precio del pedido</a>
        </p>
        <br/>

        <h3>Datos para el envío:</h3>
        <form action="{{ route('envio.guardar') }}" method="POST">
            @csrf


            <label class="input-log">
                <input checked="true" type="radio" name="tipo_envio" value="envioDomicilio" onclick="toggleFields()"> Envio a domicilio/sucursal
            </label>
            {{--  <label>
            <input type="radio" name="tipo_envio" value="envioSucursal" onclick="toggleFields()"> Envio a sucursal
            </label> --}}
            <label class="input-log">
            <input type="radio" name="tipo_envio" value="coordinarEnvio" onclick="toggleFields()"> Coordinar envio o entrega
            </label>


            <div id="dir_env">
                <label for="provincia">Provincia</label>
                <input class="input-log" id="provincia" type="text" name="provincia"  />

                <label for="localidad">Ciudad</label>
                <input class="input-log" id="localidad" type="text" name="localidad"  />


                <label for="direccion">Dirección</label>
                <input class="input-log" id="direccion" type="text" name="direccion"  />

                <label class="input-log" for="codigo_postal">Codigo Postal</label>
                <input class="input-log" id="codigo_postal"  min="0" step="1" type="number" name="codigo_postal"  />
            </div>

            <label class="input-log" for="nombre_receptor">Nombre receptor</label>
            <input class="input-log" type="text" name="nombre_receptor" required />

            <label class="input-log" for="dni_receptor">DNI receptor</label>
            <input class="input-log" type="number" min="0" step="1" name="dni_receptor" required />

            <label for="telefono">Telefono</label>
            <input class="input-log" type="number" min="0" step="1" name="telefono" required />



            <input type="submit" value="Confirmar pedido" />
        </form>
        @else
        <h1>Necesitas estar identificado</h1>
        <p>Necesitas estar logueado en la web para poder realizar tu pedido.</p>
        @endif



    </main>


    @include('components.footer')
