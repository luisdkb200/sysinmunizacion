<?php

namespace App\Exports;

use App\Models\Vacuna;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class VacunasReport implements FromView, ShouldAutoSize
{
    private $f1, $f2, $f3;

    public function __construct($f1, $f2, $f3)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->f3 = $f3;
    }

    public function view(): View
    {
        $f1 =  $this->f1;
        $f2 = $this->f2;
        $f3 = $this->f3;


        // $searchText = trim($request->get('searchText'));
        // $searchText1 = trim($request->get('searchText1'));
        $vacunas = Vacuna::findOrFail($f1);
        // $microred= DB::table('microred as mr')::all();



        $eess = DB::table('establecimiento as e')
            ->join('microred as mr', 'e.cod_microred', '=', 'mr.cod_microred')
            ->select('mr.cod_microred', 'e.nombre_est', 'e.cod_establecimiento')
            ->orderByDesc('mr.cod_microred')
            ->get();
        $mesM = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
        $anioM = ['2021', '2022', '2023', '2024', '2025'];

        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        // $searchText = empty($request->get('searchText')) ? date('n') : $request->get('searchText');
        // $searchText1 = empty($request->get('searchText1')) ? date('Y') : $request->get('searchText1');

        //   dd(self::restarUnMes($searchText, $searchText1));

        $data = [];

        foreach ($eess as $e) {
            $id_data = self::getData($f1, $f2, $f3, $e->cod_establecimiento)[0];
            $salida = self::getData($f1, $f2, $f3, $e->cod_establecimiento)[3];
            $entrada = self::getData($f1, $f2, $f3, $e->cod_establecimiento)[2];

            $saldo = self::getSaldo($f1, $f2, $f3, $e->cod_establecimiento)[0];
            $poblacion = self::getPoblacion($f1, $f2, $f3, $e->cod_establecimiento)[0];
            $data[] = ['id_data' => $id_data, 'codigo_esta' => $e->cod_establecimiento,  'cod_microred' => $e->cod_microred, 'establecimiento' => $e->nombre_est, 'salida' => $salida, 'entrada' => $entrada, 'saldo' => $saldo, 'poblacion' => $poblacion];
        }

        $saldoVacuna = DB::table('saldo as s')
            ->where('s.cod_vacuna', $f1)
            ->where('s.mes', $f2)
            ->where('s.anio', $f3)
            ->first();

        $periodo = DB::table('periodo as p')->get();
        return view('inicio.entrega_vacunas.excelVacunas', compact("saldoVacuna", "vacunas", "eess", "periodo", "f2", "f3", "mesM", "anioM", 'data'));
    }
    public static function getSaldo($id_vacuna, $mes, $anio, $id_establecimiento)
    {
        // Obtenemos el mes anterior al proporcionado
        $mes_anterior = $mes - 1;
        $anio_anterior = $anio;

        // Si el mes anterior es enero, ajustamos el año y el mes
        if ($mes_anterior == 0) {
            $mes_anterior = 12;
            $anio_anterior = $anio - 1;
        }

        $periodo = DB::table('periodo as p')
            ->where('p.cod_vacuna', $id_vacuna)
            ->where('p.mes', $mes_anterior)
            ->where('p.anio', $anio_anterior)
            ->where('p.cod_establecimiento', $id_establecimiento)
            ->first();

        if (isset($periodo->saldo)) {
            return [$periodo->saldo];
        } else {
            return [0];
        }
    }
    public static function getData($id_vacuna, $mes, $anio, $id_establecimiento)
    {


        $periodo = DB::table('periodo as p')
            ->where('p.cod_vacuna', $id_vacuna)
            ->where('p.mes', $mes)
            ->where('p.anio', $anio)
            ->where('p.cod_establecimiento', $id_establecimiento)
            ->first();

        if (isset($periodo->saldo)) {
            return [$periodo->cod_periodo, $periodo->saldo, $periodo->entrada, $periodo->salida];
        } else {
            return [-1, 0, 0, 0];
        }
    }
    public static function getPoblacion($id, $mes, $anio, $id_establecimiento)
    {
        // Calcular el mes 6 meses antes del mes dado
        $mes_inicio = $mes - 6;
        $anio_inicio = $anio;

        // Ajustar el año si el mes es menor a 1 (enero)
        while ($mes_inicio < 1) {
            $mes_inicio += 12;
            $anio_inicio--;
        }

        // Obtener la población de los 6 meses anteriores y calcular la suma
        $suma_poblacion = 0;
        for ($i = 0; $i < 6; $i++) {
            $poblacion = DB::table('poblacion as p')
                ->where('cod_establecimiento', $id_establecimiento)
                ->where('cod_vacuna', $id)
                ->where('mes', $mes_inicio)
                ->where('anio', $anio_inicio)
                ->first();

            if (isset($poblacion->poblacion_asignada)) {
                $suma_poblacion += $poblacion->poblacion_asignada;
            }

            // Pasar al mes siguiente
            $mes_inicio++;
            if ($mes_inicio > 12) {
                $mes_inicio = 1;
                $anio_inicio++;
            }
        }

        // Calcular el promedio de población
        $promedio_poblacion = ceil($suma_poblacion / 6);

        if (isset($poblacion->poblacion_asignada)) {
            return [$promedio_poblacion];
        } else {
            return [0];
        }
    }
}
