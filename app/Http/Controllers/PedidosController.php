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

    public function index(Request $request) {
        $mispedidos = Pedido::all()->where('user_id', Auth::user()->id);
        $misPedidosConProducto = [];
        foreach ($mispedidos as $pedido) {
            $productos = $pedido->productos;
            $misPedidosConProducto[] = $pedido;
        }
        return $misPedidosConProducto;
    }

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

    public function show(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->productos;
        return $pedido;
    }

    public function update(Request $request, $id) {
        $pedido = Pedido::findOrFail($id);
        $pedido->update($request->all());
        return $pedido;
    }

    public function destroy(Request $request, $id) {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        return $pedido;
    }
    
}
