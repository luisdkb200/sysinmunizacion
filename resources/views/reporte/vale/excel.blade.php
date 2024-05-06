<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vale</title>
   
   
</head>


   


<body>

    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td colspan="2" style="border: 1px solid #000000; font-size: 12px; background-color: #DAEEF3; height: 14">Centro
            de
            Acopio
        </td>
        <td colspan="11" style="border: 1px solid #000000; font-size: 12px;"></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid #000000; font-size: 12px; background-color: #DAEEF3;">Responsable de
            Recojo</td>
        <td colspan="11" style="border: 1px solid #000000; font-size: 12px;"></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid #000000; font-size: 12px; background-color: #DAEEF3;">Fecha</td>
        <td colspan="11" style="border: 1px solid #000000; font-size: 12px;"></td>
    </tr>
    <tr></tr>
    @foreach ($tabla_maestra as $t)
        <table>

            <tr>
                @if ($t['establecimiento'] == 'CONSOLIDADO')
                    <td colspan="6"
                        style="border: 1px solid #000000; font-size: 12px; text-align: center; background-color: #DAEEF3;">
                        CONSOLIDADO</td>
                @else
                    <td colspan="2" style="border: 1px solid #000000; font-size: 12px; background-color: #DAEEF3;">
                        Establecimiento</td>
                    <td colspan="4" style="border: 1px solid #000000; font-size: 12px;">
                        {{ $t['establecimiento'] }}
                    </td>
                @endif
                <td></td>
                @if (!empty($t['establecimiento2']))
                    <td colspan="2" style="border: 1px solid #000000; font-size: 12px; background-color: #DAEEF3;">
                        Establecimiento</td>
                    <td colspan="4" style="border: 1px solid #000000; font-size: 12px;">
                        {{ $t['establecimiento2'] }}
                    </td>
                @endif
            </tr>
        </table>
        <table>
            @for ($i = 0; $i < $nroFila; $i++)
                <tr>
                    @for ($j = 0; $j < 13; $j++)
                        @if ($t['matriz'][$i][$j] != 'b')
                            <td
                                style="border: {{ $t['matriz'][$i][$j] != '' ? '1px solid #000000' : '' }}; font-size: 12px">
                                {{ $t['matriz'][$i][$j] }}</td>
                        @else
                            <td style="width: 8px"></td>
                        @endif
                    @endfor
                </tr>
            @endfor
        </table>
        <tr></tr>
        <tr></tr>

    @endforeach
</body>

</html>
