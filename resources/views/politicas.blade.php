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
        <h4 style="font-weight: bold;">Política de Privacidad</h4>
        <section>
            <h5>Recolección de datos</h5>
            <p>Al realizar una compra o registrarte, recopilamos datos personales como tu nombre, dirección, teléfono y correo electrónico.</p>

            <h5>Uso de la información</h5>
            <p>Usamos tus datos únicamente para procesar pedidos, enviar productos y contactarte si es necesario.</p>

            <h5>Protección de datos</h5>
            <p>Los datos personales son almacenados de forma segura. No utilizamos cookies de terceros ni herramientas de análisis externas.</p>

            <h5>Compartir datos</h5>
            <p>No compartimos tus datos con terceros, salvo con servicios logísticos o de pago estrictamente necesarios para completar la operación.</p>

            <h5>Derechos del usuario</h5>
            <p>Podés solicitar el acceso, corrección o eliminación de tus datos enviando un correo a ......</p>
        </section>





    </main>


    @include('components.footer')



