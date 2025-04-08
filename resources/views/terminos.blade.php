<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="{{ asset('js/mi.js') }}"></script>
    <style>


        input,textArea,select{
            width: 50% !important;
        }


        input[type="submit"]{
            width: 15% !important;
            margin:20px auto;
        }
        @media (max-width: 700px) {
            input[type="submit"]{
                width: 20% !important;
            }
        }
    </style>



    @include('components.header')

    <main class="container-gestor">


        <br>
        <br>


        <h4 style="font-weight: bold;">Términos y Condiciones</h4>
        <section>
            <h5>Información general</h5>
            <p>Este sitio web pertenece a Bolsar y ofrece productos como bolsas y bobinas de papel. Al realizar una compra, aceptás estos Términos y Condiciones.</p>

            <h5>Productos y precios</h5>
            <p>Todos los precios están expresados en pesos argentinos (ARS) y pueden modificarse sin previo aviso. Las imágenes son ilustrativas.</p>

            <h5>Formas de pago</h5>
            <p>Se aceptan pagos por transferencia bancaria y Mercado Pago. La compra será procesada una vez acreditado el pago.</p>

            <h5>Envíos</h5>
            <p>Realizamos envíos dentro del territorio de la República Argentina. Los costos y tiempos de envío serán informados antes de confirmar la compra.</p>

            <h5>Cambios y devoluciones</h5>
            <p>Solo se aceptan devoluciones en caso de productos defectuosos o errores en el envío. El reclamo debe realizarse dentro de las 48 horas de recibido el pedido.</p>

            <h5>Responsabilidad</h5>
            <p>No nos hacemos responsables por demoras imputables al correo o servicios de mensajería.</p>

            <h5>Propiedad intelectual</h5>
            <p>Todo el contenido de este sitio (imágenes, textos, diseño) es propiedad de Bolsar y no puede ser reproducido sin autorización.</p>
        </section>



    </main>


    @include('components.footer')



