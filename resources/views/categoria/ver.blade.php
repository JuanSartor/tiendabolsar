<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.header')

    <main>
        <div id="content">
            @if ($categoria)
            <h1>{{ $categoria->nombre }}</h1>

            @if ($productos->isEmpty())
            <p>No hay productos para mostrar</p>
            @else


            @foreach ($productos as $product)
            <div class="product">
                <a href="{{ route('producto.ver', ['id' => $product->id]) }}">
                    @if ($product->imagen)
                    <img src="{{ asset('storage/' . $product->imagen) }}" />
                    @else
                    <img src="{{ asset('img/camiseta.png') }}" />
                    @endif
                    <h2>{{ $product->nombre }}</h2>
                </a>
                
                     <!-- 
                          COMENTO EL BOTON COMPRAR y todo lo relacionado a vender PARA PONER SOLO EL SITIO WEB
                    
                <p>$ {{ number_format($product->precio, 2, ',', '.') }}</p>

                <a href="{{ route('carrito.agregar', ['id' => $product->id]) }}" class="button">Comprar</a>
-->
            </div>
            @endforeach



            <div class="pagination-container">
                {{ $productos->links() }}
            </div>

            @endif
            @else
            <h1>La categoría no existe</h1>
            @endif
        </div>
    </main>


    @include('components.footer')