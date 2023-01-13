<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [PagesController::class, 'home']);

Route::get('mispedidos', [PedidosController::class, 'index'])->middleware('auth');

Route::get('pedido/add', [PedidosController::class, 'create'])->middleware('auth');

Route::post('pedido', [PedidosController::class, 'store'])->middleware('auth');

Route::get('subscripcion', [SubscriptionController::class, 'index'])->middleware('auth');

Route::post('subscripcion', [SubscriptionController::class, 'add']);

Route::put('subscripcion/edit/{subscription}', [SubscriptionController::class, 'edit']);

Route::get('subscripcion/delete/{subscription}', [SubscriptionController::class, 'delete']);

Route::get('producto/{producto}', [ProductoController::class, 'show']);


require __DIR__.'/auth.php';*/
