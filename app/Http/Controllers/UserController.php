<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        if($input['role_id'] && Auth::user()->role_id != 1) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }

        $user->update($request->all());
        return $user;
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }
}
