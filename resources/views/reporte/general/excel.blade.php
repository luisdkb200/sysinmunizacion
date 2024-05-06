
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>{{$vacuna->nombre}}</title> --}}


</head>

<body>
    <table style="border: 1px">
        <thead>
            <tr>

                <td colspan="6" rowspan="4" style="color: red; font-weight: bold; text-align: center">
                    {{ $nombre_vacuna->nombre }}</td>

                @foreach ($mesM as $index => $m)
                    @php
                        // Alternar entre colores para pares e impares
                        $backgroundStyle = $index % 2 === 0 ? 'background-color: #BDD7EE; font-weight: bold; text-align: center;' : 'background-color: #E2EFDA;  font-weight: bold; text-align: center';
                    @endphp
                    <td colspan="8" style="{{ $backgroundStyle }}">{{ $m }} - {{ $id }}</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($mesM as $index => $m)
                    @php
                        // Alternar entre colores para pares e impares
                        $backgroundStyle = $index % 2 === 0 ? 'background-color: #BDD7EE;  font-weight: bold; text-align: center' : 'background-color: #E2EFDA;  font-weight: bold; text-align: center';
                    @endphp

                    <td rowspan="4" style="{{ $backgroundStyle }}">SALDO<br>MES<br>ANTERIOR</td>
                    <td rowspan="2" style="{{ $backgroundStyle }}">SALIDA<br>INFORME</td>
                    <td rowspan="4" style="{{ $backgroundStyle }}">SALDO</td>
                    <td colspan="2" rowspan="2" style="{{ $backgroundStyle }}">FRAZCOS REQUERIDOS</td>
                    <td rowspan="2" style="{{ $backgroundStyle }}">ENTREGA<br>VALE</td>
                    <td rowspan="4" style="{{ $backgroundStyle }}">STOCK</td>
                    <td rowspan="4" style="{{ $backgroundStyle }}">DISPONIBLE</td>
                @endforeach
            </tr>
            <tr>
            </tr>
            <tr>
                @foreach ($mesM as $index => $m)
                    @php
                        // Alternar entre colores para pares e impares
                        $backgroundStyle = $index % 2 === 0 ? 'background-color: #BDD7EE;  font-weight: bold; text-align: center' : 'background-color: #E2EFDA;  font-weight: bold; text-align: center';
                    @endphp
                    <td rowspan="2" style="{{ $backgroundStyle }}">CANTIDAD</td>
                    <td rowspan="2" style="{{ $backgroundStyle }}">1 VACUNA 1*1</td>
                    <td rowspan="2" style="{{ $backgroundStyle }}">PARA 2 MESES</td>
                    <td rowspan="2" style="{{ $backgroundStyle }}">CANTIDAD</td>
                @endforeach
            </tr>

        </thead>
        <tr>
            <td style="background-color:#BFBFBF;  font-weight: bold; text-align: center">DISA</td>
            <td style="background-color:#BFBFBF;  font-weight: bold; text-align: center">RED</td>
            <td style="background-color:#BFBFBF;  font-weight: bold; text-align: center">ESTABLECIMIENTO</td>
            <td style="background-color:#BFBFBF;  font-weight: bold; text-align: center">COD_EST</td>
            <td style="background-color:#BFBFBF;  font-weight: bold; text-align: center">CNV</td>
            <td style="background-color:#BFBFBF;  font-weight: bold; text-align: center">CNV.N/12</td>
        </tr>

        <tbody>
            @foreach ($data as $d)
                <tr>
                    <td>CHANKA</td>
                    <td>{{ $d['nombre_red'] }} </td>
                    <td>{{ $d['nombre_establecimiento'] }}</td>
                    <td>{{ $d['codigo_est'] }}</td>
                    <td>cnv</td>
                    <td>cnv.n/12</td>
                    @foreach ($mesM as $numeroMes => $nombreMes)
                        <td>{{ $d['saldo'] }}</td>
                        <td> {{ $d['salida'] }}</td>
                        <td> {{ $d['saldo'] - $d['salida'] }}</td>
                        <td>3</td>
                        <td>4</td>
                        <td>{{ $d['entrada'] }}</td>

                        <td>{{ $d['saldo'] - $d['salida'] + $d['entrada'] }}</td>
                        <td>disponibilidad</td>
                    @endforeach
                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>
