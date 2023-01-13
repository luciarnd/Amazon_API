@section('content')
@extends('layouts.public')
<div class="container py-5" id="pedidos">
    <div class="row d-flex justify-content-between px-2">
        <h1 class="mb-3 col-10">Mis pedidos</h1>
        <a href="{{url('/pedido/add')}}" class="btn btn-primary col-2 h-100 mt-2">Añadir pedido</a>
    </div>
    @foreach($mispedidos as $pedido)
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card w-100">
                <div class="card-body p-0">
                    <h5 class="card-header row w-100 mx-0 pt-3">
                        <div class="col-3 p-0">
                            <h6 class="text-uppercase">Pedido realizado el</h6>
                            <p style="font-size: 13px;"><?= $pedido['fecha']?></p>
                        </div>
                        <div class="col-3 p-0">
                            <h6 class="text-uppercase">Total</h6>
                            <p style="font-size: 13px;"><?= $pedido['precio_total']?>€</p>
                        </div>
                        <div class="col-3 p-0">
                            <h6 class="text-uppercase">Enviar a</h6>
                            <p style="font-size: 13px;"><?= $pedido['personaReceptora'] ?></p>
                        </div>
                    </h5>
                    @foreach($pedido->productos as $producto)
                    <div class="row px-3 py-3">
                        <div class="col-lg-2 h-75">
                            <img src="{{asset($producto['image'])}}" class="p-2 w-100 h-75" alt="">
                        </div>
                        <div class="col-lg-6 col-md-7 ps-5 pt-4">
                            <h6 class="card-title fw-bold text-info"><?=$producto['descripcion']?></h6>
                            <a href="#" class="btn btn-sm btn-primary mt-2">Comprar de nuevo</a>
                        </div>
                        <div class="col-lg-4 col-md-5 py-3">
                            <a href="{{url('producto/' .$producto['id'])}}" class="btn btn-sm btn-outline-secondary mt-2 w-100">Ver articulo</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary mt-2 w-100">Contactar vendedor</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary mt-2 w-100">Escribir opinión</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <h5>Direccion de entrega</h5>
                    <p class="mb-0"><?=$pedido['direccion']?></p>
                    <span>
                        <p class="d-inline"><?=$pedido['zip']?>, </p>
                        <p class="d-inline"><?=$pedido['localidad']?></p>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
