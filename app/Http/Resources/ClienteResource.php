<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'codigo_postal' => $this->codigo_postal,
            'provincia' => [
                'id' => $this->provincia?->id,
                'nombre' => $this->provincia?->nombre,
            ],
            'vendedor' => [
                'id' => $this->vendedor?->id,
                'name' => $this->vendedor?->name,
            ],
            'tipo' => $this->tipo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
