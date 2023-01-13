@section('content')
    @extends('layouts.public')
<div class="container mt-5" id="contenedor-form">
    <h2 class="text-center titulo w-75 mb-5 p-4 mx-auto">REGISTRARSE</h2>
    <form action="{{route('register')}}" method="post" class="d-flex flex-column w-75 mx-auto">
        @csrf
        <label for="name" class="fw-bold my-3 text-start">Nombre</label>
        <input type="text" id="name" class="name p-1 w-100" placeholder="Nombre" name="name">
        <label for="apellido" class="fw-bold my-3 text-start">Apellido</label>
        <input type="text" id="apellido" class="apellido p-1 w-100" placeholder="Apellido" name="apellido">
        <label for="email" class="fw-bold my-3 text-start">Email</label>
        <input type="email" id="email" class="email p-1 w-100" placeholder="Email" name="email">
        <label for="telefono" class="fw-bold my-3 text-start">Telefono</label>
        <input type="tel" id="telefono" class="telefono p-1 w-100" placeholder="Telefono" name="telefono">
        <label for="contraseña" class="fw-bold my-3 text-start">Contraseña</label>
        <input type="password" id="contraseña" class="contraseña p-1 w-100" placeholder="Contraseña" minlength="6" name="password">
        <input type="submit" id="submit" value="Aceptar" class="btn btn-dark my-5">
    </form>
</div>
@endsection
