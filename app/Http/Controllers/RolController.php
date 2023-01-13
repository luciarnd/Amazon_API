<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Producto;
use App\Models\Roles;
use Couchbase\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $roles = Roles::all();
        return $roles;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreRol' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $rol = new Roles($input);
        if ($request->user()->cannot('store', $rol)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }

        $rol->save();
        return $rol;
    }

    public function update(Request $request, $id) {
        $rol = Roles::findOrFail($id);
        if ($request->user()->cannot('update', $rol)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $rol->update($request->all());
        return $rol;
    }

    public function destroy(Request $request, $id) {
        $rol = Roles::findOrFail($id);
        if ($request->user()->cannot('delete', $rol)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $rol->delete();
        return $rol;
    }
}
