<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClienteVehiculoController extends Controller
{
    private function authorizeCliente(Cliente $cliente)
    {
        $user = Auth::user();
        /** @var \App\Models\User|null $user */
        if (! $user) {
            abort(403);
        }
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($user->id !== $cliente->vendedor_id) {
            abort(403);
        }
    }
    public function store(Request $request, Cliente $cliente)
    {
        Gate::authorize('asignar vehiculos');
        $this->authorizeCliente($cliente);
        $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'precio' => 'required|numeric|min:0',
        ]);

        $cliente->vehiculos()->syncWithoutDetaching([
            $request->vehiculo_id => ['precio' => $request->precio]
        ]);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Vehículo asignado.');
    }

    public function destroy(Cliente $cliente, Vehiculo $vehiculo)
    {
        Gate::authorize('asignar vehiculos');
        $this->authorizeCliente($cliente);
        $cliente->vehiculos()->detach($vehiculo->id);
        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Vehículo desasignado.');
    }
}
