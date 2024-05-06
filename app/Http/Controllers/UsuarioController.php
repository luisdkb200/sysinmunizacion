<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $paginate = 15;
        $searchText = trim($request->get('searchText'));
        if ($request) {
            $usuario = User::where('name', 'LIKE', '%' . $searchText . '%')
                ->orderBy('name')
                ->paginate($paginate);
            // $roles = Role::pluck('name', 'name')->all();
            return view('acceso.usuario.index', compact("usuario", "searchText", "paginate"));
        }
    }
    public function create()
    {
        return view('acceso.usuario.create');
    }
    public function store(UsuarioFormRequest $request)
    {
        try {
            //code...
            $usuario = new User();
            $usuario->name = $request->get('name');
            $usuario->email = $request->get('email');
            if ($request->get('password') != '') {
                $usuario->password = bcrypt($request->get('password'));
            }
            // $usuario ->assignRole($request->get('roles'));
            $usuario->save();
            return Redirect::to('acceso/usuario')->with(['success' => '¡Satisfactorio!, ' . $usuario->name . ' agregado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        // $roles = Role::pluck('name', 'name')->all();
        return view("acceso.usuario.edit", ["usuario" => User::findOrFail($id)]);
    }
    public function update(UsuarioFormRequest $request, $id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->name = $request->get('name');
            $usuario->email = $request->get('email');
            if ($request->get('password') != '') {
                $usuario->password = bcrypt($request->get('password'));
            }
            $usuario->update();
            // DB::table('model_has_roles')->where('model_id', $id)->delete();

            // $usuario->assignRole($request->get("roles"));
            return Redirect::to('acceso/usuario')->with(['success' => '¡Satisfactorio!, ' . $usuario->name . ' modificado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $n_id = substr($id, 1);

        $vuser = DB::table('users')
            ->where('id', $n_id)
            ->first();
        if (isset($vuser->estUse)) {
            if ($vuser->estUse == 'ACTIVO') {
                $status = "INACTIVO";
            } else {
                $status = "ACTIVO";
            }
        }

        $users = User::findOrFail($n_id);
        $users->estUse = $status;
        $users->update();
        return Redirect::to('acceso/usuario')->with(['success' => '¡Satisfactorio!, Estado de ' . $users->name . ' modificado.']);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $docu = User::findOrFail($id);
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


    public static function rol($id)
    {
        $registro = DB::table('model_has_roles as mh')->join('roles as r', 'mh.role_id', 'r.id')
            ->where('model_id', $id)
            ->first();
        return !isset($registro->name) ? '' : $registro->name;
    }
}
