<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/pedidos",
     *      tags={"Pedidos"},
     *      summary="Get list of pedidos",
     *      description="Returns list of pedidos",
     *      security={{"bearerAuth":{}}},
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
    public function index(Request $request) {
        $mispedidos = Pedido::all()->where('user_id', Auth::user()->id);
        $misPedidosConProducto = [];
        foreach ($mispedidos as $pedido) {
            $productos = $pedido->productos;
            $misPedidosConProducto[] = $pedido;
        }
        return $misPedidosConProducto;
    }

    /**
     * @OA\Post(
     * path="/api/pedido/",
     * description="Add pedido",
     * tags={"Pedidos"},
     *     security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass pedido info",
     *    @OA\JsonContent(
     *       required={"direccion","localidad", "zip", "personaReceptora"},
     *       @OA\Property(property="direccion", type="string", format="text", example=""),
     *       @OA\Property(property="localidad", type="string", format="text", example=""),
     *         @OA\Property(property="zip", type="string", format="text", example=""),
     *       @OA\Property(property="personaReceptora", type="string", format="text", example=""),
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
        $this->validate($request, [
            'direccion' => 'required|max:255',
            'localidad' => 'required',
            'zip' => 'required',
            'personaReceptora' => 'required',
        ]);

        $input = $request->all();
        $preciototal = 0;
        $pedido = new Pedido($input);
        $productos = $input['producto'];
        foreach ($productos as $productoIdABuscar) {
            $producto = Producto::findOrFail($productoIdABuscar)->first();
            $preciototal += $producto->precio;
        }
        $user = Auth::user();
        $pedido->user()->associate($user);
        $pedido->fecha = date('d-m-Y');
        $pedido->precio_total = $preciototal;
        $pedido->save();

        $pedido->productos()->attach($productos);
        return $pedido;

    }


    /**
     * @OA\Get(
     *      path="/api/pedido/{id}",
     *      tags={"Pedidos"},
     *      summary="Get a pedido",
     *      description="Returns one pedido",
     *      security={{"bearerAuth":{}}},
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
        $pedido = Pedido::findOrFail($id);
        $pedido->productos;
        return $pedido;
    }

    /**
     * @OA\Put(
     *      path="/api/peticiones/{id}",
     *      tags={"Pedidos"},
     *      summary="Update existing pedido",
     *      description="Returns updated pedido data",
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
        $pedido = Pedido::findOrFail($id);
        $pedido->update($request->all());
        return $pedido;
    }

    /**
     * @OA\Delete(
     *      path="/api/pedido/{id}",
     *      tags={"Pedidos"},
     *      summary="Delete existing pedido",
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
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        return $pedido;
    }

}
