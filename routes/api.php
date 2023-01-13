<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(SubscriptionController::class)->group(function() {
    Route::post('subscription', 'store');
    Route::get('miSubscription', 'index');
    Route::put('subscription/{id}', 'update');
    Route::delete('subscription/{id}', 'destroy');
});

Route::controller(PedidosController::class)->group(function () {
    Route::get('misPedidos', 'index');
    Route::get('pedido/{id}', 'show');
    Route::post('pedido', 'store');
    Route::delete('pedido/{id}', 'destroy');
    Route::put('pedido/{id}', 'update');
});

Route::controller(ProductoController::class)->group(function () {
    Route::get('productos', 'index');
    Route::get('productosList', 'indexPaginated');
    Route::post('producto', 'store');
    Route::get('producto/{producto}', 'show');
    Route::put('producto/{id}', 'update');
    Route::delete('producto/{id}', 'destroy');
});

Route::controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::get('me', 'me');
});

Route::controller(UserController::class)->group(function() {
   Route::put('user/{id}', 'update');
   Route::delete('user/{id}', 'destroy');
});

Route::controller(RolController::class)->group(function() {
    Route::get('roles', 'index');
    Route::post('rol', 'store');
    Route::put('rol/{id}', 'update');
    Route::delete('rol/{id}', 'destroy');
});
