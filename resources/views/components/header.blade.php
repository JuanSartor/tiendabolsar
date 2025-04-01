<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelera Bolsar</title>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">



</head>
<body>
    <div id="container">
        <!-- CABECERA -->
        <header id="header">
            <div id="logo">
                <img src="{{asset('img/camiseta.png')}}" alt="Camiseta Logo" />
                <a href="{{ route('home') }}">
                    {{ __('Papelera Bolsar') }}
                </a>
            </div>
            @if (Route::has('login'))
            <div style="text-align: right;" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth



                <div class="dropdown">
                    <button class="dropdown-btn dropdown-btn-mob">
                        <div class="no-mobile"> <x-heroicon-o-user-circle style="width: 30px; margin-right: 5px; position: relative; top: 5px;"/>
                            {{ Auth::user()->name }} {{ Auth::user()->surname }}
                        </div>
                        <div class="solo-mob" style="font-size: 14px; cursor: pointer;">
                            &#9776; <!-- Código HTML para el icono de hamburguesa -->
                        </div>
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ url('/miperfil') }}">Mi perfil</a>
                        @if( Auth::user()->rol === 'admin')
                        <a href="{{ url('/dashboard') }}">Metricas</a>
                        @endif  
                        <hr>
                        @if( Auth::user()->rol === 'admin')
                        <a href="{{ url('/supercategorias') }}">Gestionar supercategorias</a>
                        <a href="{{ url('/categorias') }}">Gestionar categorias</a>
                        <a href="{{ url('/productos')}}">Gestionar productos</a>
                        <a href="{{ url('/pedidos')}}">Gestionar pedidos</a>
                        <a href="{{ url('/usuarios')}}">Gestionar Usuarios</a>
                        @endif  
                        <hr>
                        <a href="{{ url('/carrito') }}">Ver el carrito</a>
                        <a href="{{ url('/pedidos/mispedidos') }}">Mis pedidos</a>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link class="pd-mob" :href="route('logout')"
                                             onclick="event.preventDefault();
                                                     this.closest('form').submit();">
                                {{ __('Cerrar sesion') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>  

                @else
                <a  href="{{ route('login') }}" class="dropdown-btn btn-log-reg">{{ __('Ingresar') }}</a>

                @if (Route::has('register'))
                <a  href="{{ route('register') }}" class="dropdown-btn btn-log-reg">{{ __('Registrarse') }}</a>
                @endif
                @endauth
            </div>
            @endif
        </header>



        {{-- Menu de supercategorias--}}
        <nav id="menu">
            <ul>
                <li>
                    <a href="{{ route('home') }}">Inicio</a>
                </li>
                @foreach ($supercategorias as $supercategoria)



                <li style="line-height: 35px;">
                    <div class="dropdown">
                        <a style="background-color: #222;" class="dropdown-btn">
                            {{ ucfirst($supercategoria->nombre) }}
                        </a>

                        <div class="dropdown-content drop-cat">

                            @foreach ($supercategoria->categorias as $categoria)
                            <a style="color: #227591; font-weight: bold;" href="{{ url('categoria/ver', ['id' => $categoria->id]) }}">
                                {{ ucfirst($categoria->nombre) }}
                            </a>
                            @endforeach

                        </div>
                    </div> 
                </li>



                @endforeach
                <li>
                    <a href="{{ route('contacto') }}">Contacto</a>
                </li>

            </ul>
        </nav>  

