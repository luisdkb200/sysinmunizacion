<?php

namespace App\Http\Controllers;

use App\Http\Requests\PoblacionFormRequest;
use App\Models\Poblacion;
use App\Models\Vacuna;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PoblacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $vacunas = Vacuna::all();

        return view('registro.poblacion.index', compact("vacunas"));
    }

    public function vistaPoblacion($id, Request $request)
    {
        $acopio = trim($request->get('acopio'));
        $searchText1 = trim($request->get('searchText1'));
        $vacunas = Vacuna::findOrFail($id);

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
        $anioM = ['2021', '2022', '2023', '2024', '2025'];

        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $searchText = empty($request->get('searchText')) ? date('n') : $request->get('searchText');
        $searchText1 = empty($request->get('searchText1')) ? date('Y') : $request->get('searchText1');

        $data = [];
        $eess = DB::table('establecimiento as e')
            ->join('microred as mr', 'e.cod_microred', '=', 'mr.cod_microred')
            ->when($acopio, function ($query, $acopio) {
                return $query->where('e.cod_acopio', '=', $acopio);
            })
            ->orderByDesc('mr.cod_microred')
            ->get();

        foreach ($eess as $e) {

            $id_poblacion = self::getPoblacion($id, $searchText, $searchText1, $e->cod_establecimiento)[0];
            foreach ($mesM as $key => $value) {
                $poblacion_asignada = self::getPoblacion($id, $key, $searchText1, $e->cod_establecimiento)[1];
            }


            $data[] = [
                'id_poblacion' => $id_poblacion, 'cod_microred' => $e->cod_microred, 'codigo_esta' => $e->cod_establecimiento,
                'establecimiento' => $e->nombre_est, 'poblacion_asignada' => $poblacion_asignada
            ];
        }

        $saldoVacuna = DB::table('saldo as s')
            ->where('s.cod_vacuna', $id)
            ->where('s.mes', $searchText)
            ->where('s.anio', $searchText1)
            ->first();

        $periodo = DB::table('periodo as p')->get();

        $acopio= DB::table('acopio as a')->get();

        return view("registro.poblacion.asignacion", compact('vacunas', 'searchText', 'searchText1', 'mesM', 'anioM', 'data', 'acopio'));
    }

    public function storeAsignacion(PoblacionFormRequest $request)
    {
        // return $request->get('stockVacuna');

        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $anio = date('Y', strtotime($fecha));
        $mes = date('n', strtotime($fecha));
        // dd($request->get('cod_vacuna'));
        $eess = DB::table('establecimiento as e')
            ->get();

        $cantEst = count($eess);

        try {
            //code...



            $establecimiento = $request->get('codigo_esta');
            $id_poblacion = $request->get('id_poblacion');
            $poblacion_asignada = $request->get('poblacion_asignada');
            $poblacion_mes = $request->get('mes');
            $mes1 = $request->get('mes1');
            $mes2 = $request->get('mes2');
            $mes3 = $request->get('mes3');

            // dd($request->get('mes'));



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

            $cont = 0;

            while ($cont < count($establecimiento)) {
                foreach ($mesM as $key => $value) {
                    $poblacion = DB::table('poblacion as p')
                        ->where('cod_establecimiento', $establecimiento[$cont])
                        ->where('cod_vacuna', $request->get('cod_vacuna'))
                        ->where('mes', $key)
                        ->where('anio', $request->get('anio'))
                        ->first();
                    if (isset($poblacion->cod_poblacion)) {
                        $registro = Poblacion::findOrFail($poblacion->cod_poblacion);
                        $registro->poblacion_asignada = $request->get('mes' . $key)[$cont];
                        // $registro->poblacion_asignada = 5;
                        $registro->update();
                    } else {
                        $registro = new Poblacion();
                        $registro->cod_vacuna = $request->get('cod_vacuna');
                        $registro->mes =  $key;
                        $registro->anio = $request->get('anio');

                        $registro->cod_establecimiento = $establecimiento[$cont];
                        $registro->poblacion_asignada = $request->get('mes' . $key)[$cont] == null ? 0 : $request->get('mes' . $key)[$cont];
                        $registro->save();
                    }
                }



                $cont++;
            }


            return  redirect()->back()->with(['success' => '¡Satisfactorio!, ' . 'Poblacion de Vacuna' . ' modificado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
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
        if (isset($periodo->salida)) {
            return [$periodo->cod_periodo, $periodo->saldo, $periodo->entrada, $periodo->salida];
        } else {
            return [-1, 0, 0, 0];
        }
    }

    public static function getPoblacion($id, $mes, $anio, $id_establecimiento)
    {
        $poblacion = DB::table('poblacion as p')
            ->where('cod_establecimiento', $id_establecimiento)
            ->where('cod_vacuna', $id)
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->first();
        if (isset($poblacion->poblacion_asignada)) {
            return [$poblacion->cod_poblacion, $poblacion->poblacion_asignada];
        } else {
            return [-1, 0];
        }
    }

    // public static function getPob($id, $mes, $anio, $id_establecimiento)
    // {
    //     $poblacion = DB::table('poblacion as p')
    //         ->where('cod_establecimiento', $id_establecimiento)
    //         ->where('cod_vacuna', $id)
    //         ->where('mes', $mes)
    //         ->where('anio', $anio)
    //         ->first();
    //     if (isset($poblacion->poblacion_asignada)) {
    //         return [$poblacion->cod_poblacion, $poblacion->poblacion_asignada];
    //     } else {
    //         return [-1, 0];
    //     }
    // }
}
