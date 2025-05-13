<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="{{ asset('js/mi.js') }}"></script>

    @include('components.header')



    <main>
        <div id="content">

            <div class="row">
                <div class="col-sm-6">
                    <img class="portada" src="{{ asset('img/portadabolsa.png') }}" alt="portada">
                </div>
                <div class="col-sm-6 txt-alineacion" >
                    <h1 class="txt-h1-index slide-in-right">EL MULTIVERSO DEL PACKAGING</h1>
                    <div class="div-h2">
                        <h2 class="txt-h2-index slide-in-up"><i class="bi bi-star-fill"></i> Calidad Asegurada</h2>
                        <h2 class="txt-h2-index slide-in-up"><i class="bi bi-person-check-fill"></i> Atencion Personalizada</h2>
                        <h2 class="txt-h2-index slide-in-up"><i class="bi bi-truck"></i> Envios A Todo El Pais</h2>
                    </div>
                </div>
            </div>




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




            <div class="row">
                <h2 style="margin-left: 0px;" class="txt-h2-index slide-in-up confi">CONFIAN EN NOSOTROS</h2>
            </div>
            <div class="custom-carousel-container">
                <div class="custom-carousel" id="carousel">
                    @foreach ($imagenes as $imagen)
                    <div class="carousel-item-custom">
                        <img src="{{ asset('img/' . $imagen) }}" alt="Imagen" />
                    </div>
                    @endforeach
                </div>

                <button class="carousel-btn left" onclick="slideCarousel(-1)">‹</button>
                <button class="carousel-btn right" onclick="slideCarousel(1)">›</button>
            </div>



        </div>

    </main>



    @include('components.footer')



