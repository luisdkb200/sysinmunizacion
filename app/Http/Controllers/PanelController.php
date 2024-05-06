<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodoFormRequest;
use App\Http\Requests\SaldoVacunaFormRequest;
use App\Models\Periodo;
use App\Models\SaldoVacuna;
use App\Models\Vacuna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $searchText = trim($request->get('searchText'));
        $searchText1 = trim($request->get('searchText1'));

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
        $searchText = empty($request->get('searchText')) ? date('n') : $request->get('searchText');
        $searchText1 = empty($request->get('searchText1')) ? date('Y') : $request->get('searchText1');

        if ($request) {
            // $informe1 = [];
            // $val_aux = $searchText;
            // while (strtotime($val_aux) <= strtotime($searchText2)) {
            //     $totalAsignaciones = DB::table('asignaciones_detalles as ad')->join('asignaciones as a', 'ad.idAsignacion', 'a.idAsignacion')->where('fechaAsig', $val_aux)
            //         ->count();
            //     $totalDevolucion = DB::table('devoluciones_detalles as dd')->join('devoluciones as d', 'dd.idDevolucion', 'd.idDevolucion')->where('fechaDev', $val_aux)
            //         ->count();
            //     $totalMantenimiento = DB::table('mantenimientos')->where('fechaInicioMan', $val_aux)
            //         ->count();
            //     $informe1[] = array("fecha" => $val_aux, "asignacion" => $totalAsignaciones, "devolucion" => $totalDevolucion, "mantenimiento" => $totalMantenimiento);
            //     $val_aux = date('Y-m-d', strtotime('+1 day', strtotime($val_aux)));
            // }
            // $equipos = Equipo::all();
            // $cont_disponible = 0;
            // $cont_asignacion = 0;
            // foreach ($equipos as $e) {
            //     if (AC::obtenerEstadoEquipo($e->idEquipo) == 'ASIGNADO') {
            //         $cont_asignacion++;
            //     } elseif (AC::obtenerEstadoEquipo($e->idEquipo) == 'DISPONIBLE') {
            //         $cont_disponible++;
            //     }
            // }
            // $situacion[] = array('disponible' => $cont_disponible, 'asignacion' => $cont_asignacion);

            $informe3 = [];

            $vacuna = Vacuna::where('estado', 1)->get();


            foreach ($vacuna as $key) {
                // echo $key->nameProducts . ' ' . $key->cantidad . '<br>';
                $informe3[] = array("vacunas" =>  $key->sigla,  "cantidad" => self::obtenerSaldo($key->cod_vacuna, $searchText, $searchText1)[0]);
            }
            // dd($informe3);

            $informe2 = [];

            $establecimiento = DB::table('establecimiento as e')
                ->get();

            foreach ($establecimiento as $e) {


                $informe2[] = array("establecimiento" =>  $e->nombre_est,  "asignada" => self::poblacionMes($e->cod_establecimiento, $searchText, $searchText1));
            }


            $informe1 = [];
            $acopio = DB::table('acopio as a')           
            ->join('establecimiento as e', 'a.cod_acopio', '=', 'e.cod_acopio')
            ->select('a.cod_acopio', 'a.nombre_acopio', DB::raw('COUNT(e.cod_establecimiento) as numero_establecimientos'))
            ->groupBy('a.cod_acopio', 'a.nombre_acopio') // Agregamos nombre_acopio al GROUP BY
            ->get();

            foreach ($acopio as $a){
                $informe1[] = array("acopio" =>  $a->nombre_acopio,  "establecimientos" => $a->numero_establecimientos);
            }
            // dd($informe1);
        }
        return view('panel_control.index', compact("searchText", "searchText1", "mesM", "anioM", 'informe3', 'informe2','informe1'));
    }

    public static function obtenerSaldo($id, $mes, $anio)
    {
        $saldo = DB::table('saldo as s')
            ->where('cod_vacuna', $id)
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->first();
        if (isset($saldo->stock)) {
            return [$saldo->stock];
        } else {
            return [0];
        }
    }

    public static function poblacionMes($id, $mes, $anio)
    {
        $poblacion = DB::table('poblacion as p')
            ->where('cod_establecimiento', $id)
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->first();
        if (isset($poblacion->poblacion_asignada)) {
            return [$poblacion->poblacion_asignada];
        } else {
            return [0];
        }
    }
}
