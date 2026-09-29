<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('categorias.index');
});

Route::resource('categorias', CategoriaController::class);

Route::resource('productos', ProductoController::class);

Route::post(
    '/productos/{producto}/actualizar',
    [ProductoController::class, 'actualizar']
)->name('productos.actualizar');