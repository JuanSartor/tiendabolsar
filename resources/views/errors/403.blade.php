<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('components.header')

    <main class="container-gestor">
        <br>
        <br>
        <div class="container text-center">
            <h1 class="text-danger">403 - ACCESO DENEGADO</h1>
            <p>No tienes permiso para acceder a la direccion seleccionada</p>
            <a href="{{ url('/') }}" class=" btn-warning">Volver al Inicio</a>
        </div>
    </main>
    @include('components.footer')
