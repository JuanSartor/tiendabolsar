<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('components.header')
    <main class="container-gestor">
        <br>
        <br>
        <div class="container text-center">
            <h1 class="text-danger">404 - URL NO EXISTENTE</h1>
            <p>Direccion URL no encontrada</p>
            <a href="{{ url('/') }}" class=" btn-warning">Volver al Inicio</a>
        </div>

    </main>
    @include('components.footer')

