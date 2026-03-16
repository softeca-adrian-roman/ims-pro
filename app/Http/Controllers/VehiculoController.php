<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class VehiculoController extends Controller
{
    public function index()
    {
        // Permitimos el acceso si el usuario tiene el permiso 'ver vehiculos' o el rol 'responsable_de_zona' o 'admin'
    $user = Auth::user();
    if (! $user) {
        abort(403);
    }
    // Si el modelo de usuario tiene el método hasRole (spatie/permission), úsalo para omitir la autorización
    $perm = 'ver vehiculos';
    if (method_exists($user, 'hasRole')) {
        // Llamamos via call_user_func para evitar el error del analizador estático sobre método indefinido
        $isAdmin = call_user_func([$user, 'hasRole'], 'admin');
        $isResp  = call_user_func([$user, 'hasRole'], 'responsable_de_zona');
        if (! $isAdmin && ! $isResp) {
            Gate::authorize($perm);
        }
    } else {
        // Si no existe hasRole, fallback a la comprobación por permiso
        Gate::authorize($perm);
    }

        $vehiculos = Vehiculo::paginate(10);
        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        Gate::authorize('crear vehiculos');
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('crear vehiculos');
        $data = $request->validate([
            'nombre' => 'required',
            'referencia' => 'required|unique:vehiculos',
            'stock' => 'required|integer|min:0',
        ]);
        Vehiculo::create($data);
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo creado.');
    }

    public function show(Vehiculo $vehiculo)
    {
        Gate::authorize('ver vehiculos');
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        Gate::authorize('editar vehiculos');
        return view('vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        Gate::authorize('editar vehiculos');
        $data = $request->validate([
            'nombre' => 'required',
            'referencia' => 'required|unique:vehiculos,referencia,' . $vehiculo->id,
            'stock' => 'required|integer|min:0',
        ]);
        $vehiculo->update($data);
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        Gate::authorize('eliminar vehiculos');
        $vehiculo->delete();
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo eliminado.');
    }
}
