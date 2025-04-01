<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\SupercategoriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\DashboardController;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

/* Route::get('/', function () {
  return view('index');
  })->name('home');
 */
Route::get('/', [ProductoController::class, 'indexDestacados'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';

/* Categoria */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categoria.index');
    Route::get('/categoria/crear', [CategoriaController::class, 'crear'])->name('categoria.crear');
    Route::post('guardarCategoria', [CategoriaController::class, 'save'])->middleware('auth')->name('guardarCategoria');
    Route::get('categoria/{id}/editar', [CategoriaController::class, 'editar'])->name('categoria.editar');
    Route::delete('categoria/{id}', [CategoriaController::class, 'eliminar'])->name('categoria.eliminar');
});
Route::get('/categoria/ver/{id}', [CategoriaController::class, 'ver'])->name('categoria.ver');

/* Producto */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('producto.gestion');
    Route::get('/producto/crear', [ProductoController::class, 'crear'])->name('producto.crear');
    Route::get('producto/{id}/editar', [ProductoController::class, 'editar'])->name('producto.editar');
    Route::post('/productos', [ProductoController::class, 'guardar'])->name('producto.guardar');
    Route::delete('/productos/{id}', [ProductoController::class, 'eliminar'])->name('productos.eliminar');
});
Route::get('/producto/{id}', [ProductoController::class, 'ver'])->name('producto.ver');

/* Pedido usuario normal */

Route::middleware('auth')->group(function () {
    Route::get('/pedido/detalle/{id}', [PedidoController::class, 'detalle'])->name('pedido.detalle');
    Route::get('/pedido/realizar', [PedidoController::class, 'realizar'])->name('pedido.realizar');
    //  Route::post('/pedido/guardar', [PedidoController::class, 'guardar'])->name('pedido.guardar');
    Route::get('/pedido/confirmado', [PedidoController::class, 'confirmado'])->name('pedido.confirmar');
    Route::get('/pedidos/mispedidos', [PedidoController::class, 'mispedidos'])->name('pedido.mispedidos');
});

/* Pedido administradores */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedido.gestion');
    Route::post('/pedido/estado', [PedidoController::class, 'updateEstado'])->name('pedidos.updateEstado');
});

/* Carrito */
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito/eliminar/{index}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
Route::get('/carrito/incrementar/{index}', [CarritoController::class, 'incrementar'])->name('carrito.incrementar');
Route::get('/carrito/decrementar/{index}', [CarritoController::class, 'decrementar'])->name('carrito.decrementar');

/* Supercategoria */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/supercategoria/ver/{id}', [SupercategoriaController::class, 'ver'])->name('supercategoria.ver');
    Route::get('/supercategorias', [SupercategoriaController::class, 'index'])->name('supercategoria.index');
    Route::get('/supercategoria/crear', [SupercategoriaController::class, 'crear'])->name('supercategoria.crear');
    Route::post('/supercategoria', [SupercategoriaController::class, 'save'])->middleware('auth')->name('supercategoria.guardar');
    Route::get('supercategoria/{id}/editar', [SupercategoriaController::class, 'editar'])->name('supercategoria.editar');
    Route::delete('/supercategoria/{id}', [SupercategoriaController::class, 'eliminar'])->name('supercategoria.eliminar');
});
/* User */

Route::middleware('auth')->group(function () {
    Route::get('/miperfil', [UserController::class, 'miperfil'])->name('user.miperfil');
    Route::post('guardar', [UserController::class, 'save'])->name('guardar');
    Route::post('cambiarcontra', [UserController::class, 'cambiarContrasenia'])->name('cambiarcontra');
});

/* Envio */
Route::middleware('auth')->group(function () {
    Route::post('/envio/guardar', [EnvioController::class, 'guardar'])->name('envio.guardar');
    Route::post('/actualizar-costo-envio', [EnvioController::class, 'actualizarcostoenviobd']);
});

/* Gestion General */
Route::get('/contacto', [GeneralController::class, 'contactar'])->name('contacto');
Route::post('/consultar', [GeneralController::class, 'enviarConsulta'])->name('enviarconsulta');

/* Usuarios */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/usuario/crear', [UserController::class, 'crear'])->name('user.crear');
    Route::get('/usuarios', [UserController::class, 'usuarios'])->name('user.usuarios');
    Route::get('usuario/{id}/editar', [UserController::class, 'editar'])->name('usuario.editar');
    Route::delete('/usuario/{id}', [UserController::class, 'eliminar'])->name('usuario.eliminar');
});

/* Pago controller */
Route::middleware(['auth'])->group(function () {
    Route::get('pago/{id}/transferencia', [PagoController::class, 'pagoPorTransferencia'])->name('pago.transferencia');
    Route::get('pago/{id}/mercadopago', [PagoController::class, 'pagoMercadoPago'])->name('pago.mercadopago');
});

/* MercadoPago webhook */
Route::match(['get', 'post'], '/webhook/mercadopago', [PagoController::class, 'handle']);

