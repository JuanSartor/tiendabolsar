<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('components.header')



    <main>
        <div id="content"> 
            <br>
            <div class="row">
                <div title="Monto total vendido del mes actual" style="box-shadow: 3px 3px 8px; text-align: left;" class="col-md-4">
                    <br>
                    <h4 style="margin-left: 20px; color: #01B1EA; font-weight: bold;">Total</h4>
                    <h3 style="margin-left: 20px; font-weight: bold;">{{number_format($ventasMesActual, 2, ',', '.')}} $ARS</h3>
                </div>
                <div title="Total de clientes registrados y activos" style="box-shadow: 3px 3px 8px; text-align: left;" class="col-md-4">
                    <br>
                    <h4 style="margin-left: 20px; color: #01B1EA; font-weight: bold;">Clientes registrados</h4>
                    <h3 style="margin-left: 20px; font-weight: bold;">{{$cantidadUsuarios}}</h3>
                </div>
                <div title="Productos no eliminados y con stock disponible" style="box-shadow: 3px 3px 8px; text-align: left;" class="col-md-4">
                    <br>
                    <h4 style="margin-left: 20px; color: #01B1EA; font-weight: bold;">Productos activos</h4>
                    <h3 style="margin-left: 20px; font-weight: bold;">{{$productosActivos}}</h3>
                </div>
            </div>
            <br>
            <div class="row">
                <div style="box-shadow: 3px 3px 8px;" class="col-md-6">
                    <canvas id="myChart2"></canvas>
                </div>
                <div   style="box-shadow: 3px 3px 8px;" class="col-md-6">
                    <canvas  id="myChart"></canvas>
                </div>
            </div>


        </div>
    </main>

    @include('components.footer')


    <script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
type: 'bar',
        data: {
        labels: @json($labels),
                datasets: [{
                label: 'Ventas',
                        data: @json($data),
                        backgroundColor: @json($backgroundColors),
                        borderColor: @json($backgroundColors),
                        borderWidth: 1
                }]
        }
});
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx2, {
        type: 'line', // Gráfico de líneas
                data: {
                labels: @json($labelsLinea), // Mes y año
                        datasets: [{
                        label: 'Ventas',
                                data: @json($dataLinea), // Cantidad de ventas
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: true, // Para que la línea tenga color de fondo
                                tension: 0.3 // Suaviza la línea
                        }]
                },
                options: {
                responsive: true,
                        scales: {
                        y: {
                        beginAtZero: true
                        }
                        }
                }
        });
        });
    </script>

