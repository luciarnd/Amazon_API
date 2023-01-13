@section('content')
@extends('layouts.public')
<div class="container py-5" xmlns="http://www.w3.org/1999/html">
    <h1>Gestiona aquí tu subscripción</h1>
    <span>
        <h5 class="d-inline">Si no tienes una subscripcion, ¡subscribete ahora!</h5>
        <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#addModal">Subscribirse</button>
    </span>
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Crea tu subscripcion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body" method="post" action="{{url('subscripcion/')}}">
                        @csrf
                        @method('post')
                        <label for="plan">Plan</label>
                        <input type="text" name="plan" placeholder="Plan" class="form-control mb-3">
                        <label for="periodo">Periodo</label>
                        <input type="text" name="periodo" placeholder="Periodo" class="form-control mb-3">
                        <label for="fechainicio">Fecha de inicio</label>
                        <input type="date" name="fechainicio" placeholder="Fecha de inicio" class="form-control mb-3">
                        <label for="fechacaducidad">Fecha de caducidad</label>
                        <input type="date" name="fechacaducidad" placeholder="Fecha de caducidad" class="form-control mb-3">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                            <input type="submit" class="btn btn-primary btn-sm" value="Guardar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @foreach($subscripcion as $sub)
    <div class="row my-3">
        <div class="col-12 mb-3">
            <div class="card w-100">
                <div class="card-body p-0">
                    <div class="card-header row w-100 mx-0 pt-3">
                        <h5 class="mb-1">Tu subscripción a Amazon Prime</h5>
                        <p class="fs-6">Caduca el: <?=$sub['fechacaducidad']?></p>
                    </div>
                    <div class="row px-3">
                        <div class="col-6 py-3">
                            <p class="mb-2">Plan de subscripcion: <strong><?=$sub['plan']?></strong></p>
                            <p class="mb-2">Dada de alta: <strong><?=$sub['fechainicio']?></strong></p>
                            <p class="mb-2">Periodo de subscripcion: <strong><?= $sub['periodo']?></strong></p>
                        </div>
                        <div class="col-6 ps-5 py-3">
                            <button class="btn btn-sm btn-warning mt-2 w-100" data-bs-toggle="modal" data-bs-target="#editModal">Modificar</button>
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Modifica tu subscripcion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form class="modal-body" method="post" action="{{url('subscripcion/edit/' .$sub['id'])}}">
                                            @csrf
                                            @method('put')
                                            <label for="plan">Plan</label>
                                            <input type="text" name="plan" value="<?=$sub['plan']?>" class="form-control mb-3">
                                            <label for="periodo">Periodo</label>
                                            <input type="text" name="periodo" value="<?=$sub['periodo']?>" class="form-control mb-3">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                                <input type="submit" class="btn btn-primary btn-sm" value="Guardar">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <form action="{{url('subscripcion/delete/'.$sub['id'])}}" method="post">
                                @csrf
                                @method('delete')
                                <input type="submit" class="btn btn-sm btn-danger mt-2 w-100" value="Cancelar subscripcion"></input>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
