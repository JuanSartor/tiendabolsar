<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.header')

    <main class="container-gestor">

        <h1>{{ isset($categoria) ? "Editar categoria $categoria->nombre" : "Crear nueva categoria" }}</h1>


        <form method="POST" action="{{ route('guardarCategoria') }}" >
            @csrf
            @if(isset($categoria))
            <input type="hidden" name="id" value="{{ $categoria->id }}">
            @endif



            <label for="supercategoria">Supercategoria</label>
            <select class="input-log" name="supercategoria">
                @foreach ($supercategorias_abm as $supercategoria)
                <option value="{{ $supercategoria->id }}" {{ old('supercategoria', $categoria->id_supercategoria ?? '') == $supercategoria->id ? 'selected' : '' }}>
                    {{ $supercategoria->nombre }}
                </option>
                @endforeach
            </select>

            <label for="nombre">Nombre</label>
            <input class="input-log" type="text" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" required/>


            @if(isset($categoria))
            <label for="visible">Visible</label>
            <input type="radio" name="visible" value="1" {{ $categoria->visible == 1 ? 'checked' : '' }}> Sí
            <input type="radio" name="visible" value="0" {{ $categoria->visible == 0 ? 'checked' : '' }}> No
            @else
            <input type="hidden" name="visible" value="1">
            @endif

            <input type="submit" value="Guardar" />
        </form>



    </main>


    @include('components.footer')