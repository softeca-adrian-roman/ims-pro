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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clientes', ClienteController::class)
        ->middleware([
            PermissionMiddleware::class . ':ver clientes',
            PermissionMiddleware::class . ':crear clientes',
            PermissionMiddleware::class . ':editar clientes',
            PermissionMiddleware::class . ':eliminar clientes',
        ]);


    Route::resource('vehiculos', VehiculoController::class)
        ->middleware([
            PermissionMiddleware::class . ':ver vehiculos',
            PermissionMiddleware::class . ':crear vehiculos',
            PermissionMiddleware::class . ':editar vehiculos',
            PermissionMiddleware::class . ':eliminar vehiculos',
        ]);


    Route::post('/clientes/{cliente}/vehiculos', [ClienteVehiculoController::class, 'store'])
        ->name('clientes.vehiculos.store')
        ->middleware(PermissionMiddleware::class . ':asignar vehiculos');

    Route::delete('/clientes/{cliente}/vehiculos/{vehiculo}', [ClienteVehiculoController::class, 'destroy'])
        ->name('clientes.vehiculos.destroy')
        ->middleware(PermissionMiddleware::class . ':asignar vehiculos');

    Route::resource('vendedores', VendedorController::class)->except('show')
        ->middleware([
            PermissionMiddleware::class . ':ver vendedores',
            PermissionMiddleware::class . ':crear vendedores',
            PermissionMiddleware::class . ':editar vendedores',
            PermissionMiddleware::class . ':eliminar vendedores',
        ]);
    Route::get('/dashboard', function () {
    return view('dashboard');
    })->name('dashboard');
});
