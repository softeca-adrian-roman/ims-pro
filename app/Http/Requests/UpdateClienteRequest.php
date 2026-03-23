<?php

namespace App\Http\Requests;

use App\Enums\ClienteTipo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('clientes')->ignore($this->cliente)],
            'telefono' => 'nullable|string',
            'codigo_postal' => 'nullable|string',
            'provincia_id' => 'required|exists:provincias,id',
            'tipo' => ['required', Rule::in(ClienteTipo::values())],
            'vendedor_id' => $this->user() && $this->user()->hasRole('admin') ? 'nullable|exists:users,id' : 'prohibited',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'email.unique' => 'El email ya está registrado.',
            'provincia_id.required' => 'La provincia es obligatoria.',
            'provincia_id.exists' => 'La provincia seleccionada no existe.',
            'tipo.required' => 'El tipo de cliente es obligatorio.',
            'tipo.in' => 'El tipo de cliente no es válido.',
        ];
    }
}
