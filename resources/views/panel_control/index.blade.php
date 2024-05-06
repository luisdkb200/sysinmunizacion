@php use App\Http\Controllers\CajaController; @endphp
@extends('layouts.admin')
@section('contenido')
    <style>
        .card-body.chart-container {
            max-height: 300px;
            /* Set the maximum height for the card body */
            overflow: auto;
            /* Add a scroll bar if content overflows */
        }

        .chart-content {
            min-height: 300px;
            /* Set a minimum height for the content to prevent collapse */
        }
    </style>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>
                        <b>{{ 'Panel de Control' }}</b>
                    </h4>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
        <div class="card-body">
            @include('panel_control.search')
        </div>
    </div>



    {{-- <div class="row">
            <div class="col-lg-12 col-12">
            <div class="card card-primary">

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $data[1] }}</h3>
                                    <p>Citas de Registradas</p>
                                </div>
                                <div class="icon">
                                    <i class="far fa-calendar"></i>
                                </div>
                                <a href="{{ asset('historial/listado-cita') }}" class="small-box-footer">Info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $data[2] }}</h3>
                                    <p>Citas concluidas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <a href="{{ asset('historial/listado-cita?searchText3=CULMINADO') }}" class="small-box-footer">Info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $data[3] }}</h3>
                                    <p>Citas sin concluir</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-times"></i>
                                </div>
                                <a href="{{ asset('historial/listado-cita?searchText3=PENDIENTE') }}" class="small-box-footer">Info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $data[0] }}</h3>
                                    <p>Especialistas Activos</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="{{ asset('acceso/usuario') }}" class="small-box-footer">Más info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div> --}}
    {{-- </div> --}}
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="card">
                <div class="card-header text-white " style="background: #365c88">
                    Saldo Vacunas </div>
                <div class="card-body">
                    <canvas id="gLine" width="400" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header text-white " style="background: #365c88">
                    Establecimientos por Acopio
                </div>
                <div class="card-body">
                    <canvas id="gDona" height="100"></canvas>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-6 col-12">
            <div class="card card-primary">
                <div class="card-header text-white" style="background: #365c88">
                    Saldo de Vacunas
                </div>
                <div class="card-body chart-container">
                    <div class="chart-content">
                        <canvas id="myChart" width="400" height="500"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    @push('scripts')
        <script>
            function getRandomColor() {
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        </script>
        <script>
            const informe1 = @json($informe1);
            let acopio = [];
            let establecimientos = [];
            for (x of informe1) {
                acopio.push(x.acopio);
                establecimientos.push(x.establecimientos);
            }
            console.log(acopio);

            var ctx = document.getElementById('gDona');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: acopio,
                    datasets: [{
                        label: 'My First Dataset',
                        data: establecimientos,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            '#1DB76E',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            '27F2DD'

                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true,
                            },
                        }
                    }
                }
            });
        </script>
        <script>
            const informe3 = @json($informe3);

            let vacunas = [];
            let cantidad = [];
            for (x of informe3) {
                vacunas.push(x.vacunas);
                cantidad.push(x.cantidad);

            }

            var ctx = document.getElementById('gLine');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: vacunas,
                    datasets: [{
                        label: 'Cantidad de Vacunas',
                        data: cantidad,
                        backgroundColor: [
                            '#FF6384',
                        ],
                        borderColor: '#FF6384',
                        hoverOffset: 4
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'N° de registro por vacuna'
                        },
                    },
                    responsive: true,
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            stacked: true,
                            ticks: {
                                autoSkip: true,
                                maxRotation: 90, // Ajustar el ángulo de rotación máximo
                                minRotation: 90,
                            }
                        },
                        y: {
                            stacked: true
                        }
                    }

                }

            });
        </script>
        {{-- <script>
            const informe3 = @json($informe3);
            let nomVacuna = [];
            let cantidadEquipo = [];

            for (x of informe3) {
                nomVacuna.push(x.vacunas);
                cantidadEquipo.push(x.cantidad);
            }
            // console.log(cantidadEquipo);

            // Any of the following formats may be used
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nomVacuna,
                    datasets: [{
                        label: ['Cantidad de Vacunas'],
                        data: cantidadEquipo,
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                           
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                stepSize: 1,
                            },
                        },
                    },
                    barPercentage: 0.6
                }
            });
        </script> --}}
    @endpush
@endsection
