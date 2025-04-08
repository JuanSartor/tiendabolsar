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
            <ul>
                <li style="background: var(--verde-oscuro); ">
                    <a href="{{ route('home') }}">
                        <img style="height: 27px; margin-right: 2px;  position: relative;   bottom: 1px;" src="{{ asset('faviconw.png') }}" alt="portada">Bolsar</a>
                </li>
                @foreach ($supercategorias as $supercategoria)



                <li>
                    <div class="dropdown">
                        <a style="background-color: white; color: black; font-weight: bold;" class="dropdown-btn">
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
                <li>
                    <a style="color: black; font-weight: bold;" href="{{ route('contacto') }}">Contacto</a>
                </li>

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
                        <div class="dropdown-content">
                            <a style="color: black; " href="{{ url('/miperfil') }}">Mi perfil</a>
                            @if( Auth::user()->rol === 'admin')
                            <a href="{{ url('/dashboard') }}">Metricas</a>
                            @endif  

                            @if( Auth::user()->rol === 'admin')
                            <hr>
                            <a href="{{ url('/supercategorias') }}">Gestionar supercategorias</a>
                            <a href="{{ url('/categorias') }}">Gestionar categorias</a>
                            <a href="{{ url('/productos')}}">Gestionar productos</a>
                            <a href="{{ url('/pedidos')}}">Gestionar pedidos</a>
                            <a href="{{ url('/usuarios')}}">Gestionar Usuarios</a>
                            <hr>
                            @endif  

                            <a href="{{ url('/carrito') }}">Ver el carrito</a>
                            <a href="{{ url('/pedidos/mispedidos') }}">Mis pedidos</a>
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

