<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="{{ asset('js/mi.js') }}"></script>
    @include('components.header')

    <main class="container-gestor">
        @section('content')

        <h1>Mi Perfil</h1>
        <hr>

        @if(session('success'))
        <br>
        <br>
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <hr>
        @endif



        <form action="{{ isset($usuario) ? route('guardar', $usuario->id) : route('guardar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if(isset($usuario))
            <input type="hidden" name="id" value="{{ $usuario->id }}">
            @endif
            <label for="name">Nombre</label>
            <input class="input-log" type="text" name="name" required value="{{ old('name', $usuario->name ?? '') }}" />

            <label for="surname">Apellido</label>
            <input class="input-log"  type="text" name="surname" required value="{{ old('surname', $usuario->surname ?? '') }}" />


            <input type="submit" value="Editar" />
        </form>




        <br> <br>
        <hr>
        <br>

        <form method="POST" action="{{ route('cambiarcontra') }}" >
            @csrf
            <label class="input-log"  for="current_password">Contraseña actual</label>
            <input class="input-log"  type="password" name="current_password" required/>
            @error('current_password') <p class="text-red-500">{{ $message }}</p> @enderror

            <label class="input-log"  for="password">Nueva contraseña</label>
            <input class="input-log"  type="password" name="password" required/>
            @error('password') <p class="text-red-500">{{ $message }}</p> @enderror

            <label class="input-log"  for="password_confirmation">Repetir contraseña nueva</label>
            <input class="input-log"  type="password" name="password_confirmation" required/>


            <input type="submit" value="Cambiar contraseña" />
        </form>
        <br>


        @show
    </main>


    @include('components.footer')