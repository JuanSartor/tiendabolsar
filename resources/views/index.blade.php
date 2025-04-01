<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.header')



    <main>
        <div id="content">
            <br>
            <br>
            <div class="products-container">
                @foreach ($productos as $product)
                <div class="product">
                    <a href="{{ route('producto.ver', $product->id) }}">
                        @if ($product->imagen)
                        <img src="{{ asset('storage/' . $product->imagen) }}" alt="{{ $product->nombre }}">
                        @else
                        <img src="{{ asset('img/camiseta.png') }}" alt="Imagen por defecto">
                        @endif
                        <h2>{{ $product->nombre }}</h2>
                    </a>
                    <p>$ {{ number_format($product->precio, 2, ',', '.') }}</p>
                    <a href="{{ route('carrito.agregar', $product->id) }}" class="button">Comprar</a>
                </div>
                @endforeach
            </div>



        </div>

    </main>



    @include('components.footer')



