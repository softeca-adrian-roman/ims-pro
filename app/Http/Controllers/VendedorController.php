<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// ...existing imports...

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::role('responsable_de_zona');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $vendedores = $query->paginate(10)->withQueryString();

        return view('vendedores.index', compact('vendedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->assignRole('responsable_de_zona');

        return redirect()->route('vendedores.index')->with('success', 'Vendedor creado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $vendedor)
    {
        return view('vendedores.show', compact('vendedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $vendedor)
    {
        return view('vendedores.edit', compact('vendedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $vendedor)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $vendedor->id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $vendedor->update($data);
        return redirect()->route('vendedores.index')->with('success', 'Vendedor actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $vendedor)
    {
        foreach ($vendedor->clientes as $cliente) {
        // Si quieres también borrar registros pivote manualmente:
        $cliente->vehiculos()->detach(); // elimina relaciones en cliente_vehiculo
        $cliente->delete();
    }
        $vendedor->delete();
        return redirect()->route('vendedores.index')->with('success', 'Vendedor eliminado.');
    }
}
