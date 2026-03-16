<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('ver vendedores');

        $vendedores = User::role('responsable_de_zona')->paginate(10);

        return view('vendedores.index', compact('vendedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('crear vendedores');
        return view('vendedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('crear vendedores');
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
        Gate::authorize('ver vendedores');
        return view('vendedores.show', compact('vendedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $vendedor)
    {
        Gate::authorize('editar vendedores');
        return view('vendedores.edit', compact('vendedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $vendedor)
    {
        Gate::authorize('editar vendedores');
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
        Gate::authorize('eliminar vendedores');
        $vendedor->delete();
        return redirect()->route('vendedores.index')->with('success', 'Vendedor eliminado.');
    }
}
