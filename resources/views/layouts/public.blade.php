<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon</title>
    <link rel="icon" type="image/png" href="{{asset('images/icono.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/amazon-ember" rel="stylesheet">
    <style>
        * {
            font-family: 'Amazon Ember', sans-serif;
        }

        nav {
            background-color: #131921;

        }


        nav a , nav .but{
            font-family: 'Montserrat', sans-serif;
            display: inline!important;
        }


        .btn-primary {
            background-color: #FFD814;
            color: black;
            border: #FFD814;
        }

        .btn-primary:hover {
            background-color: #c28e00;
        }

        .text-info {
            color: #007185!important;
        }

        .card img {
            height: 236.92px;
        }

        #pedidos img {
            height: 140.92px;
        }

        .titulo {
            font-family: 'Montserrat', sans-serif;
        }

        .nav-link  {
            font-size: 14px;
        }

        .nav-link:hover {
            border-bottom: 2px solid white;
            cursor: pointer;
        }

        #log {
            padding-top: 2px!important;
        }

        .carrito:hover {
            border: 0;
        }

        a {
            text-decoration: none;
        }

        .paises li:hover {
            border-bottom: 1px solid white;
            cursor: pointer;
        }

        .paises {
            font-size: 15px;
            word-spacing: 25px;
        }

        .paises li {
            display: inline;
            word-spacing: 2px;
        }

        .map-navegacion a:hover {
            border-bottom: 1px solid white;
            cursor: pointer;
        }

        #degradado {
            position: relative;
            z-index: 1;
            height: 300px;
            top: -320px;
            width: 100%;
            background: linear-gradient(transparent, white);

        }

        #productos {
            position: relative;
            z-index: 1;
            padding-top: 5%!important;
            margin-top: -320px;
            background-color: white;
        }

        #contenedor-form h2 {
            border-bottom: #131921 2px solid;
        }

        #contenedor-form input {
            border: 2px solid #131921;
            border-radius: 5px;
        }

        @media (max-width: 650px) {
            #productos h1 {
                font-size: 20px!important;
            }

        }

        @media (max-width: 800px) {
            #carouselAmazon, .carousel-item  {
                height: 300px!important;
            }
        }


    </style>

    <script>
        function custom_template(obj){
            var data = $(obj.element).data();
            var text = $(obj.element).text();
            if(data && data['img_src']){
                img_src = data['img_src'];
                template = $("<div><img src=\"" + img_src + "\" style=\"width:100%;height:150px;\"/><p style=\"font-weight: 700;font-size:14pt;text-align:center;\">" + text + "</p></div>");
                return template;
            }
        }
        var options = {
            'templateSelection': custom_template,
            'templateResult': custom_template,
        }
        $('#id_select2_example').select2(options);
        $('.select2-container--default .select2-selection--single').css({'height': '220px'});
    </script>
</head>
<body>
<nav class="navbar navbar-dark navbar-expand-lg bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand my-2 mx-2" href="{{url('/')}}"><img style="height: 30px; width: 90px;" src="{{asset('images/logo-nav.png')}}"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav mx-lg-4 mx-md-0">
                <li class="nav-item mx-3 my-md-1 my-sm-1">
                    <a class="nav-link text-white p-0" href="{{url('mispedidos')}}">MIS PEDIDOS</a>
                </li>
                <li class="nav-item mx-3 my-md-1 my-sm-1">
                    <a class="nav-link text-white p-0" href="{{url('subscripcion')}}">SUBSCRIPCION</a>
                </li>
                <li class="nav-item mx-3 my-md-1 my-sm-1">
                    <a class="nav-link text-white p-0" href="#">CONTACTO</a>
                </li>
            </ul>
            <ul class="navbar-nav mx-lg-4 mx-md-0">
                <?php if(Auth::check()): ?>
                <li class="nav-item mx-3 my-md-1 my-sm-1 my-2 pt-2">
                    <a class="nav-link text-white pb-0 px-0" aria-current="page">Hola, <?= Auth::user()->name;?></a>
                </li>
                <li class="nav-item mx-3 my-md-1 my-sm-1 my-1">
                    <form action="{{url('logout')}}" method="POST">
                        @csrf
                        <input class="nav-link text-white pb-0 px-0 text-uppercase titulo but" aria-current="page" type="submit" value="Cerrar sesion" style="background-color: transparent">
                    </form>
                </li>
                <?php else : ?>
                <li class="nav-item mx-3 my-md-1 my-sm-1 my-1 pt-2">
                    <a class="nav-link text-white pb-0 px-0 text-uppercase" aria-current="page" href="{{url('login')}}">Iniciar sesion</a>
                </li>
                <li class="nav-item mx-3 my-md-1 my-sm-1 my-1 pt-2">
                    <a class="nav-link text-white pb-0 px-0 text-uppercase" aria-current="page" href="{{url('register')}}">Registro</a>
                </li>
                <?php endif;?>
                <li class="nav-item mx-3 my-md-1 my-sm-1 pt-2">
                    <a class="nav-link text-white p-0 carrito" href="{{url('checkout')}}">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<div class="container-fluid w-100 text-center py-4" id="volver_arriba" style="background-color: rgb(56, 56, 56);">
    <a href="#" class="text-white fw-bold">Volver arriba</a>
</div>
<footer class="bg-dark text-center text-white pt-3 px-0">
    <div class="container p-4">
        <section class="map-navegacion">
            <div class="row">
                <div class="col-lg-3 mb-4 mb-lg-5">
                    <ul class="list-unstyled mb-0 text-start">
                        <li class="p-1">
                            <a href="{{url('mispedidos')}}" class="text-white">Pedidos</a>
                        </li>
                        <li class="p-1">
                            <a href="{{url('subscripcion')}}" class="text-white">Gestiona tu subscripcion</a>
                        </li>
                        <li class="p-1">
                            <a href="#!" class="text-white">Politica de seguridad</a>
                        </li>
                        <li class="p-1">
                            <a href="#!" class="text-white">Acerca de Amazon Prime</a>
                        </li>
                        <li class="p-1">
                            <a href="#!" class="text-white">Cookies</a>
                        </li>
                        <li class="p-1">
                            <a href="#!" class="text-white">Ayuda</a>
                        </li>
                        <li class="p-1 mb-2">
                            <a href="#!" class="text-white">Contactanos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <hr style="opacity: 1;">
        <section class="mb-4 col-md-12 pt-5" id="txt">
            <p class="titulo pb-4"><img src="{{asset('images/logo-nav.png')}}" alt="logo" width="120px" height="40px"></p>
            <ul class="list-unstyled mb-0 d-inline paises">
                <li>Australia</li>
                <li>Alemania</li>
                <li>Brasil</li>
                <li>Canadá</li>
                <li>China</li>
                <li>Estados Unidos</li>
                <li>Francia</li>
                <li>India</li>
                <li>Italia</li>
                <li>Japón</li>
                <li>México</li>
                <li>Países Bajos</li>
                <li>Polonia</li>
                <li>Emiratos Árabes Unidos</li>
                <li>Reino Unido</li>
                <li>Singapur</li>
                <li>Turquía</li>
            </ul>
        </section>
    </div>
    <div class="text-center p-3 titulo" style="background-color: rgba(0, 0, 0, 0.2);">
        © 1996-2022 Copyright:
        <p class="text-white d-inline bold titulo">Amazon</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
        integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk"
        crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
        integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc"
        crossorigin="anonymous"></script>
</body>
</html>
