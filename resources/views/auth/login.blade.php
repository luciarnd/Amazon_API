@section('content')
@extends('layouts.public')
<div class="container mt-5" id="contenedor-form">
    <h2 class="text-center titulo w-75 mb-5 p-4 mx-auto">INICIA SESIÓN</h2>
    <form action="{{route('login')}}" method="post" class="d-flex flex-column w-75 mx-auto">
        @csrf
        <label for="email" class="fw-bold my-3 text-start">Email</label>
        <input type="email" id="email" class="email p-1 w-100" placeholder="Email" name="email">
        <label for="password" class="fw-bold my-3 text-start">Contraseña</label>
        <input type="password" name="password" id="password" class="password p-1 w-100" placeholder="Contraseña" minlength="6">
        <input type="submit" id="submit" value="Aceptar" class="btn btn-dark my-5">
    </form>
</div>
@endsection
