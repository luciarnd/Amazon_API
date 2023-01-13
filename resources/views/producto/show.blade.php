@section('content')
@extends('layouts.public')
<div class="container py-5">
    <div class="row">
        <div class="col-4">
            <img src="{{asset($producto['image'])}}" alt="imagen de producto" class="h-100 w-100">
        </div>
        <div class="col-7 ps-5">
            <h4 class="text-info"><?= $producto['descripcion']?></h4>
            <p>Marca: <?=$producto['marca']?></p>
            <hr>
            <h3><?=$producto['precio']?>€</h3>
            <p class="text-success">En stock</p>
            <a href="" class="btn btn-primary mt-3 px-5" style="border-radius: 20px">Comprar ahora</a>
            <a href="" class="btn btn-primary mt-3 px-5 text-white" style="border-radius: 20px; background-color: #c27400">Añadir a la cesta</a>
        </div>
    </div>
</div>
@endsection
