<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="{{ asset('js/mi.js') }}"></script>
    @include('components.header')

    <main class="container-gestor">

        <h1>Gestión usuarios</h1>
        <br>

        <div style="margin-right: 0px;" class="row">
            <div class="col-md-6">
                <a href="{{ url('/usuario/crear')}}" class="button button-small">
                    Crear Usuario
                </a>
            </div>


            <div class="col-md-6 d-flex align-items-center">
                <form method="GET" action="{{ route('user.usuarios') }}">
                    <div>
                        <input style="width: 250px;" type="text" name="search" placeholder="Buscar usuario por nombre..." value="{{ request('search') }}">
                    </div>
                    <div>
                        <button type="submit">Buscar</button>
                    </div>
                </form>

            </div>

        </div>
        <br>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <br>
        @elseif(session('failed'))
        <div class="alert alert-failed">
            {{ session('failed') }}
        </div>
        <br>
        @endif

        <table>
            <tr>
                <th class="th-cat-mobile">ID</th>
                <th class="th-cat-mobile">NOMBRE</th>
                <th class="th-cat-mobile">EMAIL</th>
                <th class="th-cat-mobile">ESTADO</th>
                <th class="th-cat-mobile">ACCIONES</th>
            </tr>
            @foreach ($usuarios as $usuario)
            <tr>
                <td class="th-cat-mobile">{{ $usuario->id }}</td>
                <td class="th-cat-mobile">{{ $usuario->name}} {{ $usuario->surname }}</td>
                <td class="th-cat-mobile">{{ $usuario->email }}</td>
                <td class="th-cat-mobile">
                    @if ($usuario->eliminado == 0)
                    <span class="badge bg-success">Activo</span>
                    @else
                    <span class="badge bg-danger">Eliminado</span>
                    @endif
                </td>
                <td class="btn-acciones class="th-cat-mobile"">
                    <a href="{{ route('usuario.editar', $usuario->id) }}" class="button button-gestion btn-solo-icono"><i class="bi bi-pencil"></i>
                        <span class="no-mobile">Editar</span></a>

                    <form action="{{ route('usuario.eliminar', $usuario->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button-gestion button-red btn-solo-icono"> <i class="bi bi-trash"></i>
                            <span class="no-mobile">Eliminar</span></button>
                    </form>
                </td>
            </tr>
            @endforeach

        </table>

        <div class="pagination-container">
            {{ $usuarios->onEachSide(0)->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}

        </div>



    </main>


    @include('components.footer')