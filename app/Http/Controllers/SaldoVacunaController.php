<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaldoVacunaFormRequest;
use App\Models\SaldoVacuna;
use App\Models\Vacuna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SaldoVacunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $paginate = 10;
        $searchText = trim($request->get('searchText'));
        $searchText1 = trim($request->get('searchText1'));


        if ($request) {
            // dd($searchText);
            $saldo_vacuna = DB::table('saldo as s')
                ->join('vacuna as v', 's.cod_vacuna', '=', 'v.cod_vacuna')
                ->when($searchText, function ($query, $searchText) {
                    return $query->where('nombre', 'LIKE', '%' . $searchText . '%');
                })
                ->when($searchText1, function ($query, $searchText1) {
                    return $query->where('mes', '=', $searchText1);
                }, function ($query) {
                    return $query->where('mes', '=', now()->format('n')); // Establecer el mes actual por defecto
                })
                ->orderByDesc('cod_saldo')
                ->paginate($paginate);
            $vacuna = Vacuna::where('estado', 1)->get();
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
            $anioM = ['2021', '2022', '2023', '2024', '2025', '2026'];
            // $searchText = empty($request->get('searchText')) ? "BCG" : $request->get('searchText');
            $searchText1 = empty($request->get('searchText1')) ? date('n') : $request->get('searchText1');
            return view('registro.saldo_vacuna.index', compact("saldo_vacuna", "searchText", "paginate", "vacuna", "mesM", "anioM", "searchText1"));
        }
    }
    public function create()
    {
        return view('registro.saldo_vacuna.create');
    }
    public function store(SaldoVacunaFormRequest $request)
    {
        try {
            //code...
            $saldo_vacuna = new SaldoVacuna();
            $saldo_vacuna->cod_vacuna = $request->get('cod_vacuna');
            $saldo_vacuna->stock = $request->get('stock');
            $saldo_vacuna->mes = $request->get('mes');
            $saldo_vacuna->anio = $request->get('anio');
            $saldo_vacuna->save();
            $v = Vacuna::findOrFail($saldo_vacuna->cod_vacuna);
            return Redirect::to('registro/saldo_vacuna')->with(['success' => '¡Satisfactorio!, ' . $saldo_vacuna->stock . ' ' . $v->nombre . ' agregadas.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $saldo_vacuna = SaldoVacuna::findOrFail($id);
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
        $anioM = ['2021', '2022', '2023', '2024', '2025', '2026'];
        $vacuna = Vacuna::where('estado', 1)->get();

        return view('registro.saldo_vacuna.edit', compact("saldo_vacuna", "anioM", "mesM", "vacuna"));
    }

    public function update(SaldoVacunaFormRequest $request, $id)
    {
        try {
            //code...
            $saldo_vacuna = SaldoVacuna::findOrFail($id);
            // $saldo_vacuna->cod_vacuna = $request->get('cod_vacuna');
            $saldo_vacuna->stock = $request->get('stock');
            // $saldo_vacuna->mes = $request->get('mes');
            // $saldo_vacuna->anio = $request->get('anio');
            $saldo_vacuna->update();
            $v = Vacuna::findOrFail($saldo_vacuna->cod_vacuna);
            return Redirect::to('registro/saldo_vacuna')->with(['success' => '¡Satisfactorio!, ' . $saldo_vacuna->stock . ' ' . $v->nombre . ' actualizadas.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            $docu = SaldoVacuna::findOrFail($id);
            if ($docu->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, No se pudo eliminar.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '¡Error!, Este registro tiene enlazado uno o más registros.',
            ]);
        }
    }
}
