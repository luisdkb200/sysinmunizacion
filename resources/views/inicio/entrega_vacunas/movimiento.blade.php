<?php use App\Http\Controllers\EntregaVacunaController as EV; ?>
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
                <b>VACUNAS - {{ $vacunas->nombre }}</b>
            </h4>
            <a href="{{ route('excelVacunas.excel', [$vacunas->cod_vacuna, $searchText, $searchText1]) }}"
                class="btn btn-default btn-sm" target="_blank">
                <i class="fas fa-file-excel text-success"></i>
            </a>


        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <!-- Contenido de la primera columna -->
                    @include('inicio.entrega_vacunas.search')
                </div>
                <div class="col-md-4 text-right">
                    <!-- Alineación a la derecha -->
                    <!-- Contenido de la primera columna -->
                    <span for="input1">Saldo Disa</span>
                    <form action="{{ route('storeMovimiento') }}" method="POST">
                        @csrf

                        <input type="text" class="form-control form-control-sm" placeholder="Saldo" id="saldoVacuna"
                            name="saldoVacuna"
                            value="{{ isset($saldoVacuna) && isset($saldoVacuna->stock) ? $saldoVacuna->stock : 0 }}">
                </div>
                <div class="col-md-4 text-right">
                    <!-- Alineación a la derecha -->
                    <!-- Contenido de la segunda columna -->
                    <span for="input2">Stock Disa</span>
                    <input type="text" class="form-control form-control-sm" placeholder="Stock" name="stockVacuna"
                        id="stockVacuna" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <div class="card-body table-responsive p-0" id="table_refresh" style="max-height: 500px; overflow-y: auto;">

                    <table id="datatable" class="table table-sm table-hover text-nowrap">
                        <thead class="text-white text-center sticky-top" style="background: #365c88">

                            <tr>
                                <th colspan="3">Establecimiento</th>
                                <th>S.M.A.</th>
                                <th>SALIDA</th>
                                <th>SALDO</th>
                                <th>CALCULO 1</th>
                                <th>CALCULO 2</th>
                                <th>CALCULO 3</th>
                                <th>ENTREGA</th>
                                <th>STOCK</th>
                                <th>DISP*</th>
                                <th>POBLACION</th>
                            </tr>
                        </thead>
                        <tbody>

                            <input type="hidden" value="{{ $vacunas->cod_vacuna }}" name="cod_vacuna">
                            <input type="hidden" name="cod_saldoVacuna"
                                value="{{ isset($saldoVacuna) && isset($saldoVacuna->cod_saldo) ? $saldoVacuna->cod_saldo : -1 }}">
                            @php($dosis = $vacunas->num_dosis)
                            <input type="hidden" value="{{ $searchText }}" name="mes">
                            <input type="hidden" value="{{ $searchText1 }}" name="anio">
                            {{-- <input type="hidden" value="{{ $data }}" name="anio" id="data"> --}}
                            @foreach ($data as $d)
                                <tr>
                                    <td
                                        style="background-color: {{ EV::obtenerColorFondo($d['cod_microred']) }}; color: white; padding: 5px;">
                                        <b>{{ $d['establecimiento'] }}</b>
                                    </td>
                                    {{-- <td style="background-color: red;"><b>{{ $d['establecimiento'] }}</b></td> --}}
                                    <td><input type="hidden" value="{{ $d['codigo_esta'] }}" name="codigo_esta[]"></td>

                                    <td><input type="hidden" class="custom-input" name="id_data[]"
                                            value="{{ $d['id_data'] }}"></td>
                                    <td align="center"><input type="text" class="custom-input" name="sma[]"
                                            value="{{ $d['saldo'] }}" id="sma_{{ $d['codigo_esta'] }}"
                                            onkeyup="calculo('{{ $d['codigo_esta'] }}');" readonly>
                                    </td>
                                    <td align="center" style="background-color: #BEF9F9;"><input type="text"
                                            class="custom-input esNumero" name="salida[]" value="{{ $d['salida'] }}"
                                            id="salida_{{ $d['codigo_esta'] }}"
                                            onkeyup="calculo('{{ $d['codigo_esta'] }}');">
                                    </td>
                                    <td align="center"><input type="text" class="custom-input" name="saldo"
                                            id="saldo_{{ $d['codigo_esta'] }}" value="{{ $d['saldo'] - $d['salida'] }}"
                                            onkeyup="calculo('{{ $d['codigo_esta'] }}');" readonly>
                                    </td>
                                    <td align="center"><input type="text" class="custom-input" name="calculo1"
                                            value="{{ ceil($d['poblacion'] * $dosis) }}"
                                            id="calculo1_{{ $d['codigo_esta'] }}"
                                            onkeyup="calculo('{{ $d['codigo_esta'] }}');" readonly>
                                    </td>
                                    <td align="center"><input type="text" class="custom-input" name="calculo2"
                                            value="{{ ceil($d['poblacion'] * $dosis) * 2 }}" id="calculo2" readonly>
                                    </td>
                                    <td align="center"><input type="text" class="custom-input" name="calculo3"
                                            value="{{ ceil($d['poblacion'] * $dosis) * 3 }}" id="calculo3" readonly>
                                    </td>
                                    <td align="center" style="background-color: #BEF9F9;"><input type="text"
                                            class="custom-input esNumero" name="entrega[]" value="{{ $d['entrada'] }}"
                                            id="entrega_{{ $d['codigo_esta'] }}"
                                            onkeyup="calculo('{{ $d['codigo_esta'] }}');">
                                    </td>

                                    <td align="center"><input type="text" class="custom-input" name="stock[]"
                                            value="" id="stock_{{ $d['codigo_esta'] }}"
                                            onkeyup="calculo('{{ $d['codigo_esta'] }}');">
                                    </td>

                                    <td align="center"><input type="text" class="custom-input" name="disponibilidad"
                                            id="disponibilidad_{{ $d['codigo_esta'] }}" value=""
                                            onkeyup="calculo('{{ $d['codigo_esta'] }}');" readonly>
                                    </td>
                                    <td align="center"><input type="text" class="custom-input" name="poblacion"
                                            value="{{ $d['poblacion'] }}" id="poblacion" readonly>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{-- {{ $usuario->appends(['searchText' => $searchText]) }} --}}
                </div>
                {{-- <div style="display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('panel_control.index') }}" type="button" class="btn btn-danger ">Volver</a>
                </div> --}}
                <div id="floating-bot"
                    style="position: fixed; bottom: 20px; right: 20px; background-color: #365c88; color: #fff; padding: 10px; border-radius: 8px; cursor: pointer;">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('entrega_vacunas.index') }}" type="button" class="btn btn-danger ">Volver</a>
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
        <script>
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
                    var inputElement = document.getElementById('entrega_' + i);
                    if (inputElement !== null) {
                        var inputValue = inputElement.value;
                        var entregaS = inputValue === '' ? 0 : parseFloat(inputValue);
                        totalSuma += entregaS;
                    }
                }

                stockDisa = saldoVacuna - totalSuma;
                // var nFinal = (n1 * 0.22) + (n2 * 0.22) + (n3 * 0.22) + (nExamen * 0.34)

                var vSaldo = sma - salida;

                var vStock = (sma - salida) + entrega;

                var vDisp = Math.floor((vStock / calculo1) * 10) / 10;
                // disp = (disp) / 10;
                // disponibilidad.value = disp.toFixed(1);               
                console.log(vDisp);



                // console.log(vDisp);
                document.getElementById('saldo_' + id).value = vSaldo;
                document.getElementById('stock_' + id).value = vStock;
                document.getElementById('stockVacuna').value = stockDisa;

                if (isFinite(vDisp) && !isNaN(vDisp)) {

                    document.getElementById('disponibilidad_' + id).value = vDisp.toFixed(1);
                } else {
                    var aux = 0;
                    document.getElementById('disponibilidad_' + id).value = aux.toFixed(1);
                }
                if (vDisp >= 2 && isFinite(vDisp)) {
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
        </script>


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
    @endpush
@endsection
