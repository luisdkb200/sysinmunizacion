<?php use App\Http\Controllers\EntregaVacunaController as EV; ?>
<?php use App\Http\Controllers\PoblacionController as PC; ?>
@extends('layouts.admin')
@section('contenido')
    <style>
        .custom-input {
            width: 50px;
            border-top: none;
            border-left: none;
            border-right: none;
            text-align: center;
            /* Personaliza el ancho según tus necesidades */
        }
    </style>

    <div class="card">
        <div class="card-header text-center">
            <h4>
                <b>POBLACION PARA VACUNA - {{ $vacunas->nombre }}</b>
            </h4>
            {{-- <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
            </a> --}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <!-- Contenido de la primera columna -->
                    @include('registro.poblacion.search')
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0" id="table_refresh"
                    style="max-height: 500px; overflow-y: auto;  margin: 0 auto;">
                    <table id="datatable" class="table table-sm table-hover text-nowrap mx-auto" style="margin: 0 auto;">
                        <thead class="text-white text-center sticky-top" style="background: #365c88">

                            <tr>
                                <th colspan="3">ESTABLECIMIENTO</th>
                                @foreach ($mesM as $m)
                                    <th>{{ $m }}</th>
                                @endforeach

                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('storeAsignacion') }}" method="POST">
                                @csrf

                                <input type="hidden" value="{{ $vacunas->cod_vacuna }}" name="cod_vacuna">

                                {{-- <input type="hidden" value="{{ $searchText }}" name="mes"> --}}
                                <input type="hidden" value="{{ $searchText1 }}" name="anio">
                                {{-- <input type="hidden" value="{{ $data }}" name="anio" id="data"> --}}
                                @foreach ($data as $d)
                                    <tr>
                                        <td
                                            style="background-color: {{ EV::obtenerColorFondo($d['cod_microred']) }}; color: white; padding: 5px;">
                                            <b>{{ $d['establecimiento'] }}</b>
                                        </td>

                                        <td><input type="hidden" value="{{ $d['codigo_esta'] }}" name="codigo_esta[]"></td>
                                        <td><input type="hidden" class="custom-input" name="id_poblacion[]"
                                                value="{{ $d['id_poblacion'] }}"></td>
                                        @foreach ($mesM as $key => $value)
                                            <td align="center">
                                                {{-- <input type="text" class="custom-input esNumero"
                                                    name="poblacion_asignada[]"
                                                    value="{{ PC::getPob($vacunas->cod_vacuna, $key, $searchText1, $d['codigo_esta']) }}"
                                                    id="poblacion_asignada"> --}}

                                                <input class="custom-input esNumero" type="text"
                                                    name="mes{{ $key }}[]"
                                                    value="{{ PC::getPoblacion($vacunas->cod_vacuna, $key, $searchText1, $d['codigo_esta'])[1] }}"
                                                    id="">
                                                <input type="hidden" name=""
                                                    value="{{ PC::getPoblacion($vacunas->cod_vacuna, $key, $searchText1, $d['codigo_esta'])[0] }}e"
                                                    id="">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                        </tbody>

                    </table>
                    {{-- {{ $usuario->appends(['searchText' => $searchText]) }} --}}
                </div>
                {{-- <div style="display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('poblacion.index') }}" type="button" class="btn btn-danger ">Volver</a>
                </div> --}}

                <div id="floating-bot"
                    style="position: fixed; bottom: 20px; right: 20px; background-color: #365c88; color: #fff; padding: 10px; border-radius: 8px; cursor: pointer;">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('poblacion.index') }}" type="button" class="btn btn-danger ">Volver</a>
                </div>
            </div>
            </form>
        </div>
        {{-- @include('acceso.usuario.create') --}}
    </div>

    @push('scripts')
        <script>
            $('.esNumero').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });
        </script>
        {{-- <script>
            function calculo(id) {
                var sma = document.getElementById('sma_' + id).value == '' ? 0 : parseFloat(document.getElementById('sma_' + id)
                    .value);
                var salida = document.getElementById('salida_' + id).value == '' ? 0 : parseFloat(document.getElementById(
                        'salida_' + id)
                    .value);
                var saldo = document.getElementById('saldo_' + id).value == '' ? 0 : parseFloat(document.getElementById(
                        'saldo_' + id)
                    .value);
                var entrega = document.getElementById('entrega_' + id).value == '' ? 0 : parseFloat(document.getElementById(
                    'entrega_' + id).value);
                var stock = document.getElementById('stock_' + id).value == '' ? 0 : parseFloat(document.getElementById(
                    'stock_' + id).value);
                var disponibilidad = document.getElementById('disponibilidad_' + id).value == '' ? 0 : parseFloat(document
                    .getElementById('disponibilidad_' + id).value);
                var calculo1 = document.getElementById('calculo1_' + id).value == '' ? 0 : parseFloat(document
                    .getElementById('calculo1_' + id).value);

                var saldoVacuna = document.getElementById('saldoVacuna').value == '' ? 0 : parseFloat(document
                    .getElementById('saldoVacuna').value);
                var stockVacuna = document.getElementById('stockVacuna').value == '' ? 0 : parseFloat(document
                    .getElementById('stockVacuna').value);
                // console.log(data.length);


                var totalSuma = 0;

                for (var i = 1; i <= data.length; i++) {
                    var inputValue = document.getElementById('entrega_' + i).value;
                    var entregaS = inputValue === '' ? 0 : parseFloat(inputValue);
                    totalSuma += entregaS;
                }

                stockDisa = saldoVacuna - totalSuma;
                // var nFinal = (n1 * 0.22) + (n2 * 0.22) + (n3 * 0.22) + (nExamen * 0.34)

                var vSaldo = sma - salida;

                var vStock = (sma - salida) + entrega;

                var vDisp = Math.floor((vStock / calculo1) * 10) / 10;
                // disp = (disp) / 10;
                // disponibilidad.value = disp.toFixed(1);               




                // console.log(vDisp);
                document.getElementById('saldo_' + id).value = vSaldo;
                document.getElementById('stock_' + id).value = vStock;
                document.getElementById('stockVacuna').value = stockDisa

                if (isFinite(vDisp) && !isNaN(vDisp)) {

                    document.getElementById('disponibilidad_' + id).value = vDisp.toFixed(1);
                } else {
                    var aux = 0
                    document.getElementById('disponibilidad_' + id).value = aux.toFixed(1);
                }
                if (vDisp >= 2) {
                    document.getElementById('disponibilidad_' + id).style.color = 'green';
                } else {
                    document.getElementById('disponibilidad_' + id).style.color = 'red';
                }
            }

            // Actualizamos la data
            let data = @json($data);

            for (x of data) {
                calculo(x.codigo_esta);

            }
        </script> --}}


        @if (Session::has('success'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @elseif(Session::has('error'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif

        {{-- <script>
            // Agregar un script que muestre SweetAlert al cargar la página
            Swal.fire({
                icon: 'info',
                title: '¡Esta es una alerta!',
                html: 'Aquí puedes colocar el contenido que desees mostrar en la alerta.',
                showCancelButton: true,
                showConfirmButton: false,
                allowOutsideClick: false, // Evita que se cierre al hacer clic fuera de la alerta.
                allowEscapeKey: false, // Evita que se cierre al presionar la tecla "Esc".
                allowEnterKey: false, // Evita que se cierre al presionar la tecla "Enter".
                timer: null, // Establece el temporizador en null para que no se cierre automáticamente.
            });
        </script> --}}
    @endpush
@endsection
