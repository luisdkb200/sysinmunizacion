<?php use App\Http\Controllers\EntregaVacunaController as EV; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table id="datatable">
        <thead class="text-white text-center sticky-top" style="background: #365c88">

            <tr>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>Establecimiento</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>S.M.A.</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>SALIDA</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>SALDO</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>CALCULO 1</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>CALCULO 2</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>CALCULO 3</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>ENTREGA</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>STOCK</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>DISP*</b></th>
                <th style="border: 1px solid black; padding: 8px; text-align: center;"><b>POBLACION</b></th>
            </tr>
        </thead>
        <tbody>


            @php($dosis = $vacunas->num_dosis)

            @foreach ($data as $d)
                <tr>
                    <td
                        style="border: 1px solid black; padding: 8px; text-align: center; background-color: {{ EV::obtenerColorFondo($d['cod_microred']) }}; color: white;">
                        <b>{{ $d['establecimiento'] }}</b>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">{{ $d['saldo'] }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center; background-color: #BEF9F9;">
                        {{ $d['salida'] }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ $d['saldo'] - $d['salida'] }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ ceil($d['poblacion'] * $dosis) }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ ceil($d['poblacion'] * $dosis) * 2 }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ ceil($d['poblacion'] * $dosis) * 3 }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center; background-color: #BEF9F9;">
                        {{ $d['entrada'] }}</td>
                    @php($stock = $d['saldo'] - $d['salida'] + $d['entrada'])
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">{{ $stock }}</td>
                    @if ($d['poblacion'] > 0 && $dosis > 0)
                        @php($disponibilidad = floor(($stock / ceil($d['poblacion'] * $dosis)) * 10) / 10)
                    @else
                        @php($disponibilidad = 0)
                    @endif
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">{{ $disponibilidad }}</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">{{ $d['poblacion'] }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>

</html>


@push('scripts')
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
@endpush
