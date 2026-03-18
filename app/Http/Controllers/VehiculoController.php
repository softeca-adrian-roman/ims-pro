<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
// ...existing imports...

class VehiculoController extends Controller
{
    // permission middleware is applied per-route in routes/web.php
    public function index()
    {
        $query = Vehiculo::query();

        if (request()->filled('nombre')) {
            $query->where('nombre', 'like', '%' . request('nombre') . '%');
        }
        if (request()->filled('referencia')) {
            $query->where('referencia', 'like', '%' . request('referencia') . '%');
        }

        $vehiculos = $query->paginate(10)->withQueryString();
        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'referencia' => 'required|unique:vehiculos',
            'stock' => 'required|integer|min:0',
            'precio_base' => 'required|numeric|min:0',
        ]);
        Vehiculo::create($data);
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo creado.');
    }

    public function show(Vehiculo $vehiculo)
    {
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        return view('vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'referencia' => 'required|unique:vehiculos,referencia,' . $vehiculo->id,
            'stock' => 'required|integer|min:0',
            'precio_base' => 'required|numeric|min:0',
        ]);
        $vehiculo->update($data);
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo eliminado.');
    }
}
