<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

     protected $fillable = [
        'nombre',
        'referencia',
        'stock',
        'precio_base',
    ];
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_vehiculo', 'vehiculo_id', 'client_id')
                ->withPivot('precio')
                ->withTimestamps();
    }

    /**
     * Calcula el precio para un cliente según su tipo.
     *
     * Regla asumida (puedes ajustarla):
     * - particular: precio_base
     * - flota: 0.90 * precio_base (10% descuento)
     * - empresa: 0.95 * precio_base (5% descuento)
     * - concesionario: 0.80 * precio_base (20% descuento)
     *
     * @param \App\Models\Cliente|\App\Enums\ClienteTipo|null $clienteOrTipo
     * @return float
     */
    public function precioPara($clienteOrTipo): float
    {
        $tipo = null;
        if ($clienteOrTipo === null) {
            $tipo = null;
        } elseif (is_object($clienteOrTipo) && isset($clienteOrTipo->tipo)) {
            $tipo = $clienteOrTipo->tipo;
        } elseif (is_string($clienteOrTipo)) {
            $tipo = $clienteOrTipo;
        } elseif (is_object($clienteOrTipo) && $clienteOrTipo instanceof \App\Enums\ClienteTipo) {
            $tipo = $clienteOrTipo->value;
        }

        $precio = (float) $this->precio_base;

        return match ($tipo) {
            \App\Enums\ClienteTipo::FLOTA, 'flota' => round($precio * 0.90, 2),
            \App\Enums\ClienteTipo::Empresa, 'empresa' => round($precio * 0.95, 2),
            \App\Enums\ClienteTipo::CONCESIONARIO, 'concesionario' => round($precio * 0.80, 2),
            default => round($precio, 2),
        };
    }
    protected function precioBaseFormateado(): Attribute{
       return  Attribute::make(
           get: fn() => number_format($this->precio_base, 2, ',', '.'). ' €',
       );
    }
}
