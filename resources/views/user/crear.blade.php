<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
                width: 80px !important;

            }

        }
    </style>



    @include('components.header')

    <main class="container-gestor">



        <h1>{{ isset($usuario) ? "Editar usuario $usuario->nombre" : "Crear nuevo usuario" }}</h1>

        <div class="form_container" style="width: 100%;">
            <form action="{{ isset($usuario) ? route('guardar', $usuario->id) : route('guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if(isset($usuario))
                <input type="hidden" name="id" value="{{ $usuario->id }}">
                <input type="hidden" name="banderaeditar" value="1">
                @endif
                <input type="hidden" name="bandera" value="1">




                <label for="name">Nombre</label>
                <input class="input-log" type="text" required name="name" value="{{ old('name', $usuario->name ?? '') }}" />

                <label for="surname">Apellido</label>
                <input class="input-log" type="text" required name="surname" value="{{ old('surname', $usuario->surname ?? '') }}" />

                <label for="email">Email</label>
                @if(isset($usuario))
                <input class="input-log" type="email" readonly required name="email" value="{{ old('email', $usuario->email ?? '') }}" />

                <div class="row" style="display: inline-flex;">

                    <label>
                        <input type="radio" name="eliminado" value="1" 
                               {{ old('eliminado', $usuario->eliminado) == 1 ? 'checked' : '' }}> Eliminado
                    </label>

                    <label>
                        <input type="radio" name="eliminado" value="0" 
                               {{ old('eliminado', $usuario->eliminado) == 0 ? 'checked' : '' }}> Activo
                    </label>


                </div>
                @else
                <input class="input-log" type="email" required name="email" value="{{ old('email', $usuario->email ?? '') }}" />
                @endif

                @if(!isset($usuario))
                <label for="password">Contraseña</label>
                <input class="input-log" type="password" required name="password" value="{{ old('email', $usuario->password ?? '') }}" />

                <label for="password_confirmation">Repetir contraseña</label>
                <input class="input-log" type="password" name="password_confirmation" required/>
                @endif


                <label for="rol">Rol</label>
                <select class="input-log" name="rol">
                    @if (isset($usuario))
                    @if ($usuario->rol ==='admin')
                    <option selected value="admin">
                        Administrador
                    </option>
                    <option value="normal">
                        Normal
                    </option>
                    @else ($usuario->rol ==='normal')
                    <option  value="admin">
                        Administrador
                    </option>
                    <option selected value="normal">
                        Normal
                    </option>
                    @endif
                    @else
                    <option selected value="admin">
                        Administrador
                    </option>
                    <option value="normal">
                        Normal
                    </option>
                    @endif

                </select>




                <input type="submit" value="Guardar" />
            </form>
        </div>





    </main>


    @include('components.footer')