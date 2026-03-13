<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ]);

        // Crear 9 vehículos más con factory
        Vehiculo::factory(9)->create();

        $clientes = Cliente::all();
        $vehiculos = Vehiculo::all();


        foreach ($vehiculos as $vehiculo) {
            $numClientes = rand(1, min(5, $clientes->count()));
            $clientesAsignados = $clientes->random($numClientes);
            foreach ($clientesAsignados as $cliente) {
                $vehiculo->clientes()->attach($cliente->id, [
                    'precio' => fake()->randomFloat(2, 5000, 50000)
                ]);
            }
        }
    }
}
