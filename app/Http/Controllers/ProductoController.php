<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'indexPaginated']]);
    }

    /**
     * @OA\Get(
     *      path="/api/productos",
     *      tags={"Productos"},
     *      summary="Get list of productos",
     *      description="Returns list of productos",
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
        $productos = Producto::all();
        return $productos;
    }

    public function indexPaginated(Request $request)
    {
        $productos = Producto::jsonPaginate();
        return $productos;
    }

    /**
     * @OA\Post(
     * path="/api/producto/",
     * description="Add productos",
     * tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass producto info",
     *    @OA\JsonContent(
     *       required={"precio","marca", "descripcion", "nombre"},
     *       @OA\Property(property="precio", type="integer", format="text", example=""),
     *       @OA\Property(property="marca", type="string", format="text", example=""),
     *         @OA\Property(property="descripcion", type="string", format="text", example=""),
     *       @OA\Property(property="nombre", type="string", format="text", example=""),
     *     @OA\Property(property="image", type="multipart/form-data", format="file", example=""),
     *    ),
     * ),
     *     @OA\Response(
     *    response=422,
     *    description="Wrong response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong data introduced")
     *        )
     *     )
     * ),
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'precio' => 'required',
            'marca' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'image' => 'required|max:4096',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        if ($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            $file->move('images/', $name);
            $input['image'] = $name;
        }

        $producto = new Producto($input);
        $producto->image = 'images/' . $input['image'];
        if ($request->user()->cannot('store', $producto)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $producto->save();

        $imgdb = new File();
        $imgdb->name = $input['image'];
        $imgdb->producto_id = $producto->id;
        $imgdb->file_path = 'public/images' . $input['image'];
        $imgdb->save();

        return $producto;
    }

    /**
     * @OA\Get(
     *      path="/api/producto/{id}",
     *      tags={"Productos"},
     *      summary="Get a producto",
     *      description="Returns one producto",
     *     @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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
    public function show(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        return $producto;
    }


    /**
     * @OA\Put(
     *      path="/api/producto/{id}",
     *      tags={"Productos"},
     *      summary="Update existing producto",
     *      description="Returns updated producto data",
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
        $producto = Producto::findOrFail($id);
        if ($request->user()->cannot('update', $producto)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $producto->update($request->all());
        return $producto;
    }

    /**
     * @OA\Delete(
     *      path="/api/producto/{id}",
     *      tags={"Productos"},
     *      summary="Delete existing producto",
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
        $producto = Producto::findOrFail($id);
        if ($request->user()->cannot('delete', $producto)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $producto->delete();
        return $producto;
    }

}
