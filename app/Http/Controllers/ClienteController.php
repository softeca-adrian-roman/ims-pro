<?php

namespace App\Http\Controllers;

use App\Enums\ClienteTipo;
use App\Exports\ClientesExport;
use App\Imports\ClientesImport;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
            abort(404);
        }
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        /** @var \App\Models\User|null $user */
        if (! $user) {
            abort(403);
        }

        $provincias = Provincia::all();
        $tipos = ClienteTipo::values();

        if ($user->hasRole('admin')) {
            $vendedores = User::role('responsable_de_zona')->get();
            $query = Cliente::with('vendedor', 'provincia');
        } else {
            $vendedores = collect([$user]);
            $query = Cliente::with('vendedor', 'provincia')->where('vendedor_id', $user->id);
        }

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($user->hasRole('admin') && $request->filled('vendedor_id')) {
            $query->where('vendedor_id', $request->vendedor_id);
        }
        if ($request->filled('provincia_id')) {
            $query->where('provincia_id', $request->provincia_id);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $clientes = $query->paginate(10)->withQueryString();

        return view('clientes.index', compact('clientes', 'provincias', 'tipos', 'vendedores'));
    }

    public function create()
    {
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
        $this->authorizeCliente($cliente);
        $vehiculosAsignados = $cliente->vehiculos;
        $vehiculosDisponibles = Vehiculo::whereDoesntHave('clientes', function ($q) use ($cliente) {
            $q->where('client_id', $cliente->id);
        })->get();
        return view('clientes.show', compact('cliente', 'vehiculosAsignados', 'vehiculosDisponibles'));
    }

    public function edit(Cliente $cliente)
    {
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
        $this->authorizeCliente($cliente);
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        /** @var \App\Models\User|null $user */
        if (! $user) {
            abort(403);
        }

        $provincias = Provincia::all();
        $tipos = ClienteTipo::values();

        if ($user->hasRole('admin')) {
            $vendedores = User::role('responsable_de_zona')->get();
            $query = Cliente::with('vendedor', 'provincia');
        } else {
            $vendedores = collect([$user]);
            $query = Cliente::with('vendedor', 'provincia')->where('vendedor_id', $user->id);
        }

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($user->hasRole('admin') && $request->filled('vendedor_id')) {
            $query->where('vendedor_id', $request->vendedor_id);
        }
        if ($request->filled('provincia_id')) {
            $query->where('provincia_id', $request->provincia_id);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $clientes = $query->get(); // Obtenemos todos los clientes filtrados, sin paginación

        return Excel::download(new ClientesExport($clientes), 'clientes.xlsx');
    }

     public function import()
    {
        Excel::import(new ClientesImport, 'clientes.xlsx');

        return redirect('/')->with('success', 'Todos los clientes han sido importados correctamente.');
    }
}
