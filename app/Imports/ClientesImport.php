<?php

namespace App\Imports;

use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\User;
use App\Enums\ClienteTipo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ClientesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    protected $errors = [];

    public function model(array $row)
    {
        $provincia = Provincia::where('nombre', $row['provincia'])->first();
        if (!$provincia) {
            $this->errors[] = "Provincia '{$row['provincia']}' no encontrada.";
            return null;
        }

        $vendedor = User::where('name', $row['vendedor'])->first();
        if (!$vendedor) {
            $this->errors[] = "Vendedor '{$row['vendedor']}' no encontrado.";
            return null;
        }

        // Buscar cliente por email
        $cliente = Cliente::where('email', $row['email'])->first();

        $data = [
            'nombre' => $row['nombre'],
            'email' => $row['email'],
            'telefono' => isset($row['telefono']) ? (string) $row['telefono'] : null,
            'codigo_postal' => isset($row['codigo_postal']) ? (string) $row['codigo_postal'] : null,
            'provincia_id' => $provincia->id,
            'vendedor_id' => $vendedor->id,
            'tipo' => $row['tipo'],
        ];

        if ($cliente) {
            $cliente->update($data);
            return null;
        }

        return new Cliente($data);
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'nullable|max:20',
            'codigo_postal' => 'nullable|max:20',
            'provincia' => 'required|exists:provincias,nombre',
            'vendedor' => 'required|exists:users,name',
            'tipo' => 'required|in:' . implode(',', ClienteTipo::values()),
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = "Fila {$failure->row()}: " . implode(', ', $failure->errors());
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
