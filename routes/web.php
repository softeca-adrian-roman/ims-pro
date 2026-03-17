<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ClienteVehiculoController;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clientes routes with per-action permission middleware
    Route::get('clientes', [ClienteController::class, 'index'])
        ->name('clientes.index')
        ->middleware(PermissionMiddleware::class . ':ver clientes');

    Route::get('clientes/create', [ClienteController::class, 'create'])
        ->name('clientes.create')
        ->middleware(PermissionMiddleware::class . ':crear clientes');

    Route::post('clientes', [ClienteController::class, 'store'])
        ->name('clientes.store')
        ->middleware(PermissionMiddleware::class . ':crear clientes');

    Route::get('clientes/{cliente}', [ClienteController::class, 'show'])
        ->name('clientes.show')
        ->middleware(PermissionMiddleware::class . ':ver clientes');

    Route::get('clientes/{cliente}/edit', [ClienteController::class, 'edit'])
        ->name('clientes.edit')
        ->middleware(PermissionMiddleware::class . ':editar clientes');

    Route::put('clientes/{cliente}', [ClienteController::class, 'update'])
        ->name('clientes.update')
        ->middleware(PermissionMiddleware::class . ':editar clientes');

    Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])
        ->name('clientes.destroy')
        ->middleware(PermissionMiddleware::class . ':eliminar clientes');

    // Vendedores routes with per-action permission middleware (except show)
    Route::get('vendedores', [VendedorController::class, 'index'])
        ->name('vendedores.index')
        ->middleware(PermissionMiddleware::class . ':ver vendedores');

    Route::get('vendedores/create', [VendedorController::class, 'create'])
        ->name('vendedores.create')
        ->middleware(PermissionMiddleware::class . ':crear vendedores');

    Route::post('vendedores', [VendedorController::class, 'store'])
        ->name('vendedores.store')
        ->middleware(PermissionMiddleware::class . ':crear vendedores');

    Route::get('vendedores/{vendedor}', [VendedorController::class, 'show'])
        ->name('vendedores.show')
        ->middleware(PermissionMiddleware::class . ':ver vendedores');

    Route::get('vendedores/{vendedor}/edit', [VendedorController::class, 'edit'])
        ->name('vendedores.edit')
        ->middleware(PermissionMiddleware::class . ':editar vendedores');

    Route::put('vendedores/{vendedor}', [VendedorController::class, 'update'])
        ->name('vendedores.update')
        ->middleware(PermissionMiddleware::class . ':editar vendedores');

    Route::delete('vendedores/{vendedor}', [VendedorController::class, 'destroy'])
        ->name('vendedores.destroy')
        ->middleware(PermissionMiddleware::class . ':eliminar vendedores');
    // Vehiculos routes with per-action permission middleware
    Route::get('vehiculos', [VehiculoController::class, 'index'])
        ->name('vehiculos.index')
        ->middleware(PermissionMiddleware::class . ':ver vehiculos');

    Route::get('vehiculos/create', [VehiculoController::class, 'create'])
        ->name('vehiculos.create')
        ->middleware(PermissionMiddleware::class . ':crear vehiculos');

    Route::post('vehiculos', [VehiculoController::class, 'store'])
        ->name('vehiculos.store')
        ->middleware(PermissionMiddleware::class . ':crear vehiculos');

    Route::get('vehiculos/{vehiculo}', [VehiculoController::class, 'show'])
        ->name('vehiculos.show')
        ->middleware(PermissionMiddleware::class . ':ver vehiculos');

    Route::get('vehiculos/{vehiculo}/edit', [VehiculoController::class, 'edit'])
        ->name('vehiculos.edit')
        ->middleware(PermissionMiddleware::class . ':editar vehiculos');

    Route::put('vehiculos/{vehiculo}', [VehiculoController::class, 'update'])
        ->name('vehiculos.update')
        ->middleware(PermissionMiddleware::class . ':editar vehiculos');

    Route::delete('vehiculos/{vehiculo}', [VehiculoController::class, 'destroy'])
        ->name('vehiculos.destroy')
        ->middleware(PermissionMiddleware::class . ':eliminar vehiculos');


    Route::post('/clientes/{cliente}/vehiculos', [ClienteVehiculoController::class, 'store'])
        ->name('clientes.vehiculos.store')
        ->middleware(PermissionMiddleware::class . ':asignar vehiculos');

    Route::delete('/clientes/{cliente}/vehiculos/{vehiculo}', [ClienteVehiculoController::class, 'destroy'])
        ->name('clientes.vehiculos.destroy')
        ->middleware(PermissionMiddleware::class . ':asignar vehiculos');


});
