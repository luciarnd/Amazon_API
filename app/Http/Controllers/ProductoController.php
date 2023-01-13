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

    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);
        if ($request->user()->cannot('update', $producto)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $producto->update($request->all());
        return $producto;
    }

    public function destroy(Request $request, $id) {
        $producto = Producto::findOrFail($id);
        if ($request->user()->cannot('delete', $producto)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $producto->delete();
        return $producto;
    }

}
