<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Database\Seeder;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un vehículo manual
        Vehiculo::create([
            'nombre' => 'Seat Ibiza',
            'referencia' => 'SEAT123',
            'stock' => 10,
            'precio_base' => 15000.00,
        ]);

        // Crear 9 vehículos más con factory
        Vehiculo::factory(9)->create();

        $clientes = Cliente::all();
        $vehiculos = Vehiculo::all();


        foreach ($vehiculos as $vehiculo) {
            $numClientes = rand(1, min(5, $clientes->count()));
            $clientesAsignados = $clientes->random($numClientes);
            foreach ($clientesAsignados as $cliente) {
                // Calcular precio según el tipo del cliente usando el método del modelo
                $precio = $vehiculo->precioPara($cliente);
                $vehiculo->clientes()->attach($cliente->id, [
                    'precio' => $precio
                ]);
            }
        }
    }
}
