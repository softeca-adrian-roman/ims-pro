<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

     protected $fillable = [
        'nombre',
        'referencia',
        'stock',
    ];
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_vehiculo', 'vehiculo_id', 'client_id')
                ->withPivot('precio')
                ->withTimestamps();
    }
}
