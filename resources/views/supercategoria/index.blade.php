<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="{{ asset('js/mi.js') }}"></script>

    <!-- Agrega los scripts necesarios para Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    @include('components.header')

    <main class="container-gestor">

        <h1>Gestionar Supercategorias</h1>

        <div style="margin-right: 0px;" class="row">
            <div class="col-md-6 6 d-flex align-items-center">

                <a href="{{ url('/categoria/crear')}}" class="button button-small btn-cat-sup">
                    Crear categoria
                </a>

                <a  style="margin-left: 20px;"  href="{{ url('/supercategoria/crear')}}" class="button button-small btn-cat-sup">
                    Crear supercategoria
                </a>

            </div>

            <div class="col-md-6 d-flex align-items-center">
                <form method="GET" action="{{ route('supercategoria.index') }}">
                    <div>
                        <input style="width: 280px;" type="text" name="search" placeholder="Buscar supercategoria por nombre..." value="{{ request('search') }}">
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


        <br>
        <br>
        <table>
            <tr>
                <th class="th-mobile">ID</th>
                <th class="th-mobile">SUPERCATEGORIA</th>
                <th class="th-mobile">ESTADO</th>
                <th class="th-mobile">ACCIONES</th>
            </tr>
            @foreach ($supercategorias_t as $sup)
            <tr>
                <td class="th-mobile">{{ $sup->id }}</td>
                <td class="th-mobile">{{ $sup->nombre }}</td>
                <td class="th-mobile">
                    @if ($sup->visible == 1)
                    <span class="badge bg-success">Visible</span>
                    @else
                    <span class="badge bg-danger">No visible</span>
                    @endif
                </td>
                <td class="btn-acciones th-mobile">
                    <a href="{{ route('supercategoria.editar', $sup->id) }}" class="button button-gestion">Editar</a>

                    <button type="button" class="button button-gestion button-red delete-btn" 
                            data-id="{{ $sup->id }}" 
                            data-bs-toggle="modal" 
                            data-bs-target="#confirmModal">
                        Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="pagination-container">
            {{ $supercategorias_t->onEachSide(0)->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>


    </main>


    @include('components.footer')


    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta supercategoría? Tambien eliminara sus categorias asociadas
                </div>
                <div class="modal-footer">
                    <form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Script para actualizar la acción del formulario -->
    <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            let supercategoriaId = this.getAttribute("data-id");
            let deleteForm = document.getElementById("deleteForm");
            deleteForm.setAttribute("action", "{{ route('supercategoria.eliminar', '') }}/" + supercategoriaId);
        });
    });
});
    </script>