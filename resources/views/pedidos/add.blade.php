@extends('layouts.public')
@section('content')
<div class="container py-5">
    <div class="row">
        <h1>Crea tu nuevo pedido</h1>
    </div>
    <div class="row mt-3">
        <h6>Elige los productos que quieres comprar</h6>
        <form method="post" action="{{url('pedido')}}">
        @csrf
        @method('post')
        <select class="form-select mb-3" multiple aria-label="Select pedido" id="producto" name="producto[]">
            <option selected>Elige un producto</option>
            @foreach($productos as $producto)
            <option value="<?=$producto['id']?>" data-img_src="<?=$producto['image']?>">
                <?=$producto['nombre']?>
            </option>
            @endforeach
        </select>
        <label for="personaReceptora">Introduce tu nombre</label>
        <input type="text" name="personaReceptora" placeholder="Nombre" class="form-control mb-3">
        <label for="direccion">Introduce la dirección</label>
        <input type="text" name="direccion" placeholder="Direccion" class="form-control mb-3">
        <label for="zip">Introduce el codigo postal</label>
        <input type="text" name="zip" placeholder="Codigo postal" class="form-control mb-3">
        <label for="localidad">Introduce la localidad</label>
        <input type="text" name="localidad" placeholder="Localidad" class="form-control mb-3">
            <input type="submit" value="Aceptar" class="btn btn-dark w-100">
        </form>
    </div>
</div>
@endsection
