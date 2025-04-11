<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Pedido;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Producto;

class DashboardController extends Controller {

    public function index() {


        ///////////////////////////////////////
        // DATOS DEL GRAFICO DE BARRAS VERTICALES
        //////////////////////////////////////
        $fechaInicio = Carbon::now()->subMonths(11)->startOfMonth(); // Hace 11 meses
        $fechaFin = Carbon::now()->endOfMonth(); // Fin del mes actual

        $ventas = Pedido::selectRaw('YEAR(created_at) as anio, MONTH(created_at) as mes_num, COUNT(id) as cantidad')
                ->where('estado', 'pagado')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin]) // Solo últimos 12 meses
                ->groupBy('anio', 'mes_num')
                ->orderBy('anio')
                ->orderBy('mes_num')
                ->get();

// Establecer la configuración regional en español
        setlocale(LC_TIME, 'es_ES.UTF-8');

// Crear etiquetas combinando mes y año
        // Crear etiquetas con meses en español
        $labels = $ventas->map(function ($venta) {
            $mesNombre = Carbon::create()->month($venta->mes_num)->locale('es')->translatedFormat('F');
            return ucfirst($mesNombre) . " " . $venta->anio;
        });

        $data = $ventas->pluck('cantidad');

        // Lista de colores para cada mes (puedes personalizarla)
        $colores = [
            'rgba(255, 99, 132, 0.6)', // Rojo
            'rgba(54, 162, 235, 0.6)', // Azul
            'rgba(255, 206, 86, 0.6)', // Amarillo
            'rgba(75, 192, 192, 0.6)', // Verde agua
            'rgba(153, 102, 255, 0.6)', // Morado
            'rgba(255, 159, 64, 0.6)', // Naranja
            'rgba(231, 233, 237, 0.6)', // Gris claro
            'rgba(255, 99, 255, 0.6)', // Rosa
            'rgba(100, 200, 200, 0.6)', // Turquesa
            'rgba(200, 200, 100, 0.6)', // Mostaza
            'rgba(150, 150, 255, 0.6)', // Azul suave
            'rgba(100, 255, 100, 0.6)'  // Verde claro
        ];

// Asegurar que los colores coincidan con la cantidad de meses
        $backgroundColors = array_slice($colores, 0, count($labels));

        /////////////////////////////////////
        // DATOS DE GRAFICO DE LINEA
        ////////////////////////////////////

        $fechaInicioLinea = Carbon::now()->subMonths(12)->startOfMonth(); // Hace 12 meses
        $fechaFinLinea = Carbon::now()->endOfMonth(); // Hasta el mes pasado

        $ventasLinea = Pedido::selectRaw('YEAR(created_at) as anio, MONTH(created_at) as mes_num, SUM(costo_envio+costo_productos) as costo')
                ->where('estado', 'pagado')
                ->whereBetween('created_at', [$fechaInicioLinea, $fechaFinLinea])
                ->groupBy('anio', 'mes_num')
                ->orderBy('anio')
                ->orderBy('mes_num')
                ->get();

// Establecer configuración regional en español
        setlocale(LC_TIME, 'es_ES.UTF-8');

// Crear etiquetas en español con formato "Mes Año"
        $labelsLinea = $ventasLinea->map(fn($ventasLinea) => ucfirst(Carbon::create()->month($ventasLinea->mes_num)->locale('es')->translatedFormat('F')) . " " . $ventasLinea->anio);
        $dataLinea = $ventasLinea->pluck('costo');

        //////////////////
        // DATOS DE LAS VENTAS DEL MES ACTUAL
        //////////////////

        $ventasMesActual = Pedido::whereMonth('created_at', Carbon::now()->month)
                ->where('estado', 'pagado')
                ->whereYear('created_at', Carbon::now()->year)
                ->sum(DB::raw('costo_productos + costo_envio')); // Suma el total de todas las ventas del mes actual
        ///////////////////////
        // DATOS DEL TOTAL DE CLIENTES REGISTRADOS Y NO ELIMINADOS
        ///////////////////////

        $cantidadUsuarios = User::where('rol', 'normal') // Filtra por rol 'normal'
                ->where('eliminado', 0) // Filtra por usuarios no eliminados (eliminado = 0)
                ->count(); // Cuenta la cantidad de usuarios
        //////////////////////
        // DATOS DE LOS PRODUCTOS ACTIVOS
        //////////////////////

        $productosActivos = Producto::where('stock', '>', '0')
                ->where('eliminado', 0)
                ->count();

        return view('dashboard',
                compact('labels', 'data', 'backgroundColors', 'labelsLinea', 'dataLinea', 'ventasMesActual', 'cantidadUsuarios', 'productosActivos'));
    }
}
