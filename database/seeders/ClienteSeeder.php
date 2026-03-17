<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $responsable_de_zona = User::where('email', 'responsable_de_zona@example.com')->first();
        $provincia = Provincia::first();

        if ($responsable_de_zona && $provincia) {
            Cliente::create([
                'nombre' => 'Cliente Demo',
                'email' => 'cliente@demo.com',
                'telefono' => '123456789',
                'codigo_postal' => '08001',
                'provincia_id' => $provincia->id,
                'vendedor_id' => $responsable_de_zona->id,
                'tipo' => 'particular',
            ]);
        }
        Cliente::factory(20)->create();
    }
}
