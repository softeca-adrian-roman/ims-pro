<?php

namespace App\Models;

use App\Enums\ClienteTipo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    use HasFactory;
    protected $table = 'clientes';
    protected $casts = [
    'tipo' => ClienteTipo::class,
    ];
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'codigo_postal',
        'provincia_id',
        'vendedor_id',
        'tipo',
    ];
    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
    public function vendedor()
    {
        return $this->belongsTo(User::class,'vendedor_id');
    }
    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, 'cliente_vehiculo', 'client_id', 'vehiculo_id')
                ->withPivot('precio')
                ->withTimestamps();
    }
}
