<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstablecimientoFormRequest;
use App\Models\Establecimiento;
use App\Models\Poblacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EstablecimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $paginate = 15;
        $searchText = trim($request->get('searchText'));
        if ($request) {
            $establecimiento = DB::table('establecimiento as e')
                ->join('microred as mr', 'e.cod_microred', '=', 'mr.cod_microred')
                ->join('acopio as a', 'e.cod_acopio', '=', 'a.cod_acopio')
                ->where('nombre_est', 'LIKE', '%' . $searchText . '%')
                ->orderByDesc('mr.cod_microred')
                ->paginate($paginate);
            $microred = DB::table('microred as mr')->get();
            $acopio = DB::table('acopio as ac')->get();
            return view('registro.establecimiento.index', compact("establecimiento", "searchText", "paginate", "microred", "acopio"));
        }
    }

    public function create()
    {
        return view('registro.establecimiento.create');
    }

    public function store(EstablecimientoFormRequest $request)
    {
        try {
            //code...
            $establecimiento = new Establecimiento();
            $establecimiento->nombre_est = $request->get('nombre_est');
            $establecimiento->codigo_est = $request->get('codigo_est');
            $establecimiento->cod_microred = $request->get('cod_microred');
            $establecimiento->cod_acopio = $request->get('cod_acopio');
            $establecimiento->save();
            return Redirect::to('registro/establecimiento')->with(['success' => '¡Satisfactorio!, ' . $establecimiento->nombre_est . ' agregado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        $establecimiento = Establecimiento::findOrFail($id);
        $microred = DB::table('microred as mr')->get();
        $acopio = DB::table('acopio as ac')->get();
        return view("registro.establecimiento.edit", compact("establecimiento", "microred", "acopio"));
    }

    public function update(EstablecimientoFormRequest $request, $id)
    {
        try {
            //code...
            $establecimiento = Establecimiento::findOrFail($id);
            $establecimiento->nombre_est = $request->get('nombre_est');
            $establecimiento->codigo_est = $request->get('codigo_est');
            $establecimiento->cod_microred = $request->get('cod_microred');
            $establecimiento->cod_acopio = $request->get('cod_acopio');
            $establecimiento->update();
            return Redirect::to('registro/establecimiento')->with(['success' => '¡Satisfactorio!, ' . $establecimiento->nombre_est . ' actualizado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $docu = Establecimiento::findOrFail($id);

            $docu2 = Poblacion::where('cod_establecimiento', '=', $id);
            $docu2->delete();
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
