<?php

namespace App\Exports;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{

    public function __construct(protected Collection $clientes = new Collection())
    {

    }
    public function collection()
    {
        return $this->clientes ?? Cliente::with('provincia', 'vendedor')->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Email',
            'Teléfono',
            'Código Postal',
            'Provincia',
            'Vendedor',
            'Tipo',
            'Creado',
        ];
    }

    public function map($cliente): array
    {
        return [
            $cliente->nombre,
            $cliente->email,
            $cliente->telefono,
            $cliente->codigo_postal,
            $cliente->provincia?->nombre ?? '',
            $cliente->vendedor?->name ?? '',
            (is_object($cliente->tipo) && isset($cliente->tipo->value)) ? $cliente->tipo->value : $cliente->tipo,
            $cliente->created_at?->toDateTimeString() ?? '',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'e0ff8e']]],
        ];
    }
}
