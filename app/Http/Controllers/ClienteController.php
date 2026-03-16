<?php

namespace App\Http\Controllers;

use App\Enums\ClienteTipo;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClienteController extends Controller
{
    public function authorizeCliente(Cliente $cliente)
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
    public function index()
    {
        Gate::authorize('ver clientes');
        $user = Auth::user();
        /** @var \App\Models\User|null $user */
        if (! $user) {
            abort(403);
        }
        if ($user->hasRole('admin')) {
            $clientes = Cliente::with('vendedor', 'provincia')->paginate(10);
        } else {
            $clientes = $user->clientes()->with('vendedor', 'provincia')->paginate(10);
        }
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
       Gate::authorize('crear clientes');
        $provincias = Provincia::all();
        $tipos = ClienteTipo::values();
        $user = Auth::user();

        /** @var \App\Models\User|null $user */
        if (! $user) {
            abort(403);
        }
        if ($user->hasRole('admin')) {
            $vendedores = User::role('responsable_de_zona')->get();
        } else {
            $vendedores = collect([$user]);
        }

        return view('clientes.create', compact('provincias', 'tipos', 'vendedores'));
    }

    public function store(Request $request)
    {
        Gate::authorize('crear clientes');
        $data = $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:clientes',
            'telefono' => 'nullable',
            'codigo_postal' => 'nullable',
            'provincia_id' => 'required|exists:provincias,id',
            'tipo' => 'required|in:' . implode(',', ClienteTipo::values()),
        ]);

        $user = Auth::user();

            /** @var \App\Models\User|null $user */
            if (! $user) {
                abort(403);
            }
            if ($user->hasRole('admin')) {
                $data['vendedor_id'] = $request->vendedor_id;
            } else {
                $data['vendedor_id'] = $user->id;
            }

        Cliente::create($data);
        return redirect()->route('clientes.index')->with('success', 'Cliente creado.');
    }

    public function show(Cliente $cliente)
    {
        Gate::authorize('ver clientes');
        $this->authorizeCliente($cliente);
        $vehiculosAsignados = $cliente->vehiculos;
        $vehiculosDisponibles = Vehiculo::whereDoesntHave('clientes', function ($q) use ($cliente) {
            $q->where('client_id', $cliente->id);
        })->get();
        return view('clientes.show', compact('cliente', 'vehiculosAsignados', 'vehiculosDisponibles'));
    }

    public function edit(Cliente $cliente)
    {
        Gate::authorize('editar clientes');
        $this->authorizeCliente($cliente);
        $provincias = Provincia::all();
        $tipos = ClienteTipo::values();
        $user = Auth::user();

        /** @var \App\Models\User|null $user */
        if (! $user) {
            abort(403);
        }
        if ($user->hasRole('admin')) {
            $vendedores = User::role('responsable_de_zona')->get();
        } else {
            $vendedores = collect([$user]);
        }

        return view('clientes.edit', compact('cliente', 'provincias', 'tipos', 'vendedores'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        Gate::authorize('editar clientes');
        $this->authorizeCliente($cliente);
        $data = $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefono' => 'nullable',
            'codigo_postal' => 'nullable',
            'provincia_id' => 'required|exists:provincias,id',
            'tipo' => 'required|in:' . implode(',', ClienteTipo::values()),
        ]);

        $user = Auth::user();

            /** @var \App\Models\User|null $user */
            if (! $user) {
                abort(403);
            }
            if ($user->hasRole('admin')) {
                $data['vendedor_id'] = $request->vendedor_id;
            } else {
                $data['vendedor_id'] = $user->id;
            }

        $cliente->update($data);
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Cliente $cliente)
    {
        Gate::authorize('eliminar clientes');
        $this->authorizeCliente($cliente);
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
    }
}
