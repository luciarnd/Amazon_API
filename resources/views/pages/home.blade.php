@section('content')
@extends('layouts.public')
<div class="container-fluid p-0" id="arriba">
    <div class="row w-100 m-0">
        <div id="carouselAmazon" class="carousel slide p-0 w-100 h-100" data-bs-ride="carousel" data-bs-ride="true">
            <div class="carousel-inner h-100">
                <div class="carousel-item active">
                    <img class="d-block w-100 h-100" src="images/Slide1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 h-100" src="images/slide3.jpg" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 h-100" src="images/slide4.jpg" alt="Fourth slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 h-100" src="images/slide5.jpg" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 h-100" src="images/slide6.jpg" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 h-100" src="images/slide7.jpg" alt="Third slide">
                </div>
            </div>
        </div>
    </div>
    <div class="row m-0" id="degradado">
        <br><br><br><br><br><br>
    </div>
</div>
<div class="container-fluid p-0 w-100 pb-5" id="productos">
    <div class="row w-100">
        <div class="col-12 p-0 pt-lg-5 pb-lg-5 pt-sm-3 pb-sm-3">
            <h1 class="text-center text-uppercase fw-bold fs-2 px-5 pb-3" >Descubre nuestra variedad de productos</h1>
        </div>
    </div>
    <div class="row px-5 pt-lg-3 w-100 pt-sm-3 pb-sm-3 pt-2" >
        @foreach($productos as $producto)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-sm-3 mb-3">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title text-center text-uppercase fw-bold"><?= $producto['nombre']?></h5>
                </div>
                <a href="{{url(('producto/' .$producto['id']))}}" class="w-100">
                    <img src="{{asset($producto['image'])}}" alt="imagen" class="p-2 w-100">
                </a>
                <div class="card-body d-flex flex-row justify-content-between">
                    <p class="card-text mt-3 mb-1 text-info"><?= $producto['precio']?>€</p>
                    <a href="#" class="btn btn-primary mt-2 py-2 h-50">Añadir a la cesta</a>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12 w-100 pt-3">
            <button class="btn btn-outline-secondary w-100 me-auto">Ver más</button>
        </div>
        <hr class="mx-auto w-100" style="opacity: 1; margin-top: 50px; color: gray;">
    </div>
    @if(!Auth::check())
    <div class="container-fluid" id="login">
        <div class="col-12 text-center">
            <p>Ver recomendaciones personalizadas</p>
            <a class="btn btn-primary mb-3 px-5" href="{{url('login')}}">Identifícate</a>
            <p class="pb-5">¿Eres cliente nuevo? <span><a href="{{url('register')}}">Empieza aquí</a></span></p>
        </div>
    </div>
@endif
@endsection
