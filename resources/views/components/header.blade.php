<style>
    /* Ocultar el menú normal en mobile */
    @media (max-width: 768px) {
        .menu-desktop {
            display: none;
        }
        .lable-super{
            cursor: pointer;
            color: black;
            font-weight: bold;
            font-size: 13px;
            padding-left: 7px;
            padding-right: 7px;
            font-family: cursive;
            width: 90%;
        }
        .lbl-productos{
            font-size: 13px;
            font-weight: bold;
            color: black;
            cursor: pointer;
            font-family: cursive;
            width: 100px;
            border: 2px solid var(--verde-oscuro);
            border-radius: 10px;
            align-items: center;
            text-align: center;
            margin-top: 0px;
            margin-right: 10px;
        }
        .a-contact{
            border: 2px solid var(--verde-oscuro) !important;
            border-radius: 10px;
            align-items: center;
            text-align: center;

        }
    }

    /* Ocultar el menú hamburguesa en escritorio */
    @media (min-width: 769px) {
        .menu-mobile {
            display: none;
        }
    }



    .mobile-cat-menu {
        display: none;
        background: white;
        padding: 10px;
        position: absolute;
        z-index: 999;
        width: 200px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Mostrar el menú principal cuando se abre la hamburguesa */
    #menu-mobile-toggle:checked + label + .mobile-cat-menu {
        display: block;
    }

    .submenu-mobile {
        display: none;
    }

    /* Mostrar categorías cuando se selecciona una supercategoría */
    input[type="checkbox"]:checked + label + .submenu-mobile {
        display: block;
    }
</style>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelera Bolsar</title>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('fav.png') }}">


</head>
<body>
    <div id="container">




        {{-- Menu de supercategorias--}}
        <nav id="menu">
            <ul class="pdl2">

                <!-- Menu desktop -->
                <li class="menu-desktop" style="background: var(--verde-oscuro); ">
                    <a href="{{ route('home') }}">
                        <img style="height: 27px;   position: relative;   bottom: 1px;" src="{{ asset('faviconw.png') }}" alt="portada">
                        <span class="ocultar-mob">Bolsar</span>
                    </a>
                </li>


                @foreach ($supercategorias as $supercategoria)

                <li class="menu-desktop">
                    <div class="dropdown">
                        <a  style="background-color: white; color: black; font-weight: bold;" class="dropdown-btn pdlr5">
                            {{ ucfirst($supercategoria->nombre) }}
                        </a>

                        <div class="dropdown-content drop-cat">

                            @foreach ($supercategoria->categorias as $categoria)
                            <a style="color: black;" href="{{ url('categoria/ver', ['id' => $categoria->id]) }}">
                                {{ ucfirst($categoria->nombre) }}
                            </a>
                            @endforeach

                        </div>
                    </div> 
                </li>



                @endforeach

                <!-- ------------------------------------- -->
                <!-- ------------------------------------- -->
                <!-- ------------------------------------- -->

                
                
                
                <!-- Menu mobile -->
                <li class="menu-mobile" >

                    <!-- Control general: hamburguesa -->
                    <input type="checkbox" id="menu-mobile-toggle" style="display: none;">
                    <label for="menu-mobile-toggle" class="lbl-productos" 
                           style="">
                        &#9776; Productos
                    </label>

                    <!-- Menú desplegable -->
                    <div class="mobile-cat-menu">

                        @foreach ($supercategorias as $supercategoria)

                        <!-- Control individual por supercategoría -->
                        <input type="checkbox" id="supercat-{{ $supercategoria->id }}" style="display: none;">
                        <label for="supercat-{{ $supercategoria->id }}" class="lable-super" >
                            {{ ucfirst($supercategoria->nombre) }} &#9662; <!-- Flecha hacia abajo -->
                        </label>

                        <!-- Categorías dentro de la supercategoría -->
                        <div class="submenu-mobile">
                            @foreach ($supercategoria->categorias as $categoria)

                            <a style="color: var(--verde-oscuro); font-weight: bold;  display: block; line-height: 2; margin-bottom: 2px; border: 1px solid;" href="{{ url('categoria/ver', ['id' => $categoria->id]) }}">
                                {{ ucfirst($categoria->nombre) }}
                            </a>

                            @endforeach
                        </div>

                        @endforeach


                    </div>

                </li>

                <li >
                    <a class="pdlr5 a-contact" style="color: black; font-weight: bold;" href="{{ route('contacto') }}">Contacto</a>
                </li>
                <!-- ------------------------------------- -->
                <!-- ------------------------------------- -->
                <!-- ------------------------------------- -->



                <li class="li-ingresar">
                    @if (Route::has('login'))

                    @auth



                    <div class="dropdown">
                        <button class="dropdown-btn dropdown-btn-mob">
                            <div class="no-mobile"> <x-heroicon-o-user-circle style="width: 30px; margin-right: 5px; "/>
                                {{ Auth::user()->name }} {{ Auth::user()->surname }}
                            </div>
                            <div class="solo-mob" style="font-size: 14px; cursor: pointer;">
                                &#9776; <!-- Código HTML para el icono de hamburguesa -->
                            </div>
                        </button>
                        <div class="dropdown-content drop-menu">
                            <a class="ajuste-drop" style="color: black; " href="{{ url('/miperfil') }}">Mi perfil</a>
                            @if( Auth::user()->rol === 'admin')
                            <a class="ajuste-drop"  href="{{ url('/dashboard') }}">Metricas</a>
                            @endif  

                            @if( Auth::user()->rol === 'admin')
                            <hr style="color: black;">
                            <a class="ajuste-drop"  href="{{ url('/supercategorias') }}">Gestionar supercategorias</a>
                            <a class="ajuste-drop"  href="{{ url('/categorias') }}">Gestionar categorias</a>
                            <a class="ajuste-drop"  href="{{ url('/productos')}}">Gestionar productos</a>
                            <a class="ajuste-drop"  href="{{ url('/pedidos')}}">Gestionar pedidos</a>
                            <a class="ajuste-drop"  href="{{ url('/usuarios')}}">Gestionar Usuarios</a>
                            <hr style="color: black;">
                            @endif  

                            <a class="ajuste-drop"  href="{{ url('/carrito') }}">Ver el carrito</a>
                            <a class="ajuste-drop"  href="{{ url('/pedidos/mispedidos') }}">Mis pedidos</a>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link style="padding-left: 12px !important;" class="pd-mob" :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                         this.closest('form').submit();">
                                    {{ __('Cerrar sesion') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>  

                    @else
                    <a  href="{{ route('login') }}" class="dropdown-btn btn-log-reg btn-ing-bol">{{ __('Ingresar') }}</a>
                    @endauth

                    @endif
                </li>
            </ul>
        </nav>  

