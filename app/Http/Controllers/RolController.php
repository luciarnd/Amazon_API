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

    /**
     * @OA\Get(
     *      path="/api/roles",
     *      tags={"Roles"},
     *      summary="Get all roles",
     *      description="Returns all roles",
     *     security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
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

    /**
     * @OA\Put(
     *      path="/api/rol/{id}",
     *      tags={"Roles"},
     *      summary="Update existing rol",
     *      description="Returns updated rol data",
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *     @OA\JsonContent(
     *      @OA\Property(property="", type="string", format="text", example=""),
     *    ),
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * )
     */
    public function update(Request $request, $id) {
        $rol = Roles::findOrFail($id);
        if ($request->user()->cannot('update', $rol)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $rol->update($request->all());
        return $rol;
    }

    /**
     * @OA\Delete(
     *      path="/api/rol/{id}",
     *      tags={"Roles"},
     *      summary="Delete existing rol",
     *      description="Deletes a record and returns no content",
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Request $request, $id) {
        $rol = Roles::findOrFail($id);
        if ($request->user()->cannot('delete', $rol)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $rol->delete();
        return $rol;
    }
}
