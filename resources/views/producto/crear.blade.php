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
        @section('content')


        <h1>{{ isset($producto) ? "Editar producto $producto->nombre" : "Crear nuevo producto" }}</h1>

        <div class="form_container" style="width: 100%;">
            <form action="{{ isset($producto) ? route('producto.guardar', $producto->id) : route('producto.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if(isset($producto))
                <input type="hidden" name="id" value="{{ $producto->id }}">
                @endif
                <div class="cont-cont">
                    <div class="cont-50-desk" >


                        <label for="nombre">Nombre</label>
                        <input class="input-log" type="text" required name="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}" />

                        <label for="descripcion">Descripción</label>
                        <textarea class="input-log" required name="descripcion">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>

                        <label for="precio">Precio</label>
                        <input class="input-log" required step="0.01" min="0" type="number" name="precio" value="{{ old('precio', $producto->precio ?? '') }}" />

                        <label for="stock">Stock</label>
                        <input class="input-log" required step="1" min="0" type="number" name="stock" value="{{ old('stock', $producto->stock ?? '') }}" />

                        <label for="categoria">Categoría</label>
                        <select class="input-log" name="categoria">
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria', $producto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                            @endforeach
                        </select>

                        <label  for="imagen">Imagen</label>
                        @if(isset($producto) && $producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="thumb" />
                        @endif
                        <input class="input-log"  type="file" name="imagen" />


                    </div>

                    <div class="cont-50-desk">
                        <br>
                        <h2 style="text-decoration: underline;">Datos necesarios para configurar el envio</h2>


                        <label for="alto">Alto(cm)</label>
                        <input class="input-log" required step="0.01" min="0" type="number" name="alto" value="{{ old('alto', $producto->alto ?? '') }}" />

                        <label for="ancho">Ancho(cm)</label>
                        <input class="input-log" required step="0.01" min="0" type="number" name="ancho" value="{{ old('ancho', $producto->ancho ?? '') }}" />

                        <label for="largo">Largo(cm)</label>
                        <input class="input-log" required step="0.01" min="0" type="number" name="largo" value="{{ old('largo', $producto->largo ?? '') }}" />

                        <label for="peso">Peso(gramos)</label>
                        <input class="input-log" required step="0.01" min="0" type="number" name="peso" value="{{ old('peso', $producto->peso ?? '') }}" />

                        @if(isset($producto) )
                        <div class="row" style="display: inline-flex;">

                            <label>
                                <input type="radio" name="eliminado" value="1" 
                                       {{ old('eliminado', $producto->eliminado) == 1 ? 'checked' : '' }}> Eliminado
                            </label>

                            <label>
                                <input type="radio" name="eliminado" value="0" 
                                       {{ old('eliminado', $producto->eliminado) == 0 ? 'checked' : '' }}> Activo
                            </label>


                        </div>
                        @endif
                    </div>

                </div>
                <input type="submit" value="Guardar" />
            </form>
        </div>




        @show
    </main>


    @include('components.footer')