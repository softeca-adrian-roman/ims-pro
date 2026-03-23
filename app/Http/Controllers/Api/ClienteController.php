<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\User;
use App\Enums\ClienteTipo;
use App\Http\Resources\ClienteResource;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('provincia', 'vendedor')->get();
        return ClienteResource::collection($clientes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes',
            'telefono' => 'nullable|string|max:20',
            'codigo_postal' => 'nullable|string|max:10',
            'provincia_id' => 'required|exists:provincias,id',
            'vendedor_id' => 'required|exists:users,id',
            'tipo' => 'required|in:' . implode(',', ClienteTipo::values()),
        ]);

        $cliente = Cliente::create($validated);
        return response()->json($cliente->load('provincia', 'vendedor'), 201);
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente->load('provincia', 'vendedor', 'vehiculos'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefono' => 'nullable',
            'codigo_postal' => 'nullable',
            'provincia_id' => 'required|exists:provincias,id',
            'vendedor_id' => 'required|exists:users,id',
            'tipo' => 'required|in:' . implode(',', ClienteTipo::values()),
        ]);

        $cliente->update($validated);
        return response()->json($cliente->fresh('provincia', 'vendedor'));
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado']);
    }
}
