<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.header')

    <main class="container-gestor">
        @section('content')

        <h1>{{ isset($supercategoria) ? "Editar supercategoria $supercategoria->nombre" : "Crear nuevo supercategoria" }}</h1>
        <form method="POST" action="{{ isset($supercategoria) ? route('supercategoria.guardar', $supercategoria->id) : route('supercategoria.guardar') }}" >
            @csrf

            @if(isset($supercategoria))
            <input type="hidden" name="id" value="{{ $supercategoria->id }}">
            @endif


            <label for="nombre">Nombre</label>
            <input class="input-log" type="text" name="nombre" value="{{ old('nombre', $supercategoria->nombre ?? '') }}" required/>

            @if(isset($supercategoria))
            <label for="visible">Visible</label>
            <input type="radio" name="visible" value="1" {{ $supercategoria->visible == 1 ? 'checked' : '' }}> Sí
            <input type="radio" name="visible" value="0" {{ $supercategoria->visible == 0 ? 'checked' : '' }}> No
            @else
            <input type="hidden" name="visible" value="1">
            @endif

            <input type="submit" value="Guardar" />
        </form>



        @show
    </main>


    @include('components.footer')