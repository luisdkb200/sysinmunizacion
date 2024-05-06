<?php

namespace App\Exports;

use App\Models\Establecimiento;
use App\Models\Vacuna;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class GeneralReport implements FromView, ShouldAutoSize, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $f1;

    private $cod_vacuna;

    public function __construct($f1, $cod_vacuna)
    {
        $this->f1 = $f1;
        $this->cod_vacuna = $cod_vacuna;

        //  $this->f2 = $f2;


    }
    public function view(): view
    {

        $id = $this->f1;
        $cod_vacuna = $this->cod_vacuna;

        // $id1 = $this->f2;
        // $id2 = $this->f3;
        $id = $id == '-1' ? '' : $id;

        $mesM = [
            1 => 'ENERO',
            2 => 'FEBRERO',
            3 => 'MARZO',
            4 => 'ABRIL',
            5 => 'MAYO',
            6 => 'JUNIO',
            7 => 'JULIO',
            8 => 'AGOSTO',
            9 => 'SEPTIEMBRE',
            10 => 'OCTUBRE',
            11 => 'NOVIEMBRE',
            12 => 'DICIEMBRE'
        ];

        $establecimiento = DB::table('establecimiento as e')
            ->join('microred as mr', 'e.cod_microred', '=', 'mr.cod_microred')
            ->join('red as r', 'mr.cod_red', '=', 'r.cod_red')
            ->orderByDesc('mr.cod_microred')
            ->select('e.codigo_est', 'r.nombre_red', 'e.nombre_est', 'e.cod_establecimiento')
            ->get();

    

        $data = [];

        $nombre_vacuna = DB::table('vacuna as v')
            ->Where('v.cod_vacuna', '=', $this->cod_vacuna)
            ->first();





        foreach ($establecimiento as $e) {
            $datos = self::obtenerDatos($id, $e->cod_establecimiento, array_keys($mesM), $this->cod_vacuna);
            $saldo = $datos[0];
            $salida = $datos[1];
            $entrada = $datos[2];

            $data[] = ['saldo' => $saldo, 'salida' => $salida, 'entrada' => $entrada, 'nombre_establecimiento' => $e->nombre_est, 'nombre_red' => $e->nombre_red, 'codigo_est' => $e->codigo_est];
        }
        // dd($data);



        return view('reporte.general.excel', compact('mesM', 'nombre_vacuna', 'id', 'data'));
    }
    public function title(): string
    {
        $vacuna = DB::table('vacuna as v')
            ->Where('v.cod_vacuna', '=', $this->cod_vacuna)
            ->first();
        return $vacuna->sigla;
    }


   

    public static function obtenerDatos($anio, $mes, $cod_establecimiento, $cod_vacuna)
    {
        $periodo = DB::table('periodo as p')
            ->where('cod_establecimiento', $cod_establecimiento)
            ->where('cod_vacuna', $cod_vacuna)
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->first();
        if (isset($periodo->saldo)) {
            return [$periodo->saldo, $periodo->salida, $periodo->entrada];
        } else {
            return [0, 0, 0];
        }
    }
}
