<!DOCTYPE html>
<html>
    <head>
        <title>Consulta por formulario de contacto</title>
    </head>
    <body>
        <h1>{{ $datos['nombre'] }} le ha enviado la siguiente consulta:</h1>
        <br>
        <p>{{ $datos['mensaje'] }}</p>

        <h2>Datos de contacto:</h2> 
        <p>Nombre: {{ $datos['nombre'] }}</p>
        <p>Telefono: {{ $datos['telefono'] }}</p>
        <p>Correo electronico: {{ $datos['email_contacto'] }}</p>
    </body>
</html>