<?php

namespace Database\Factories;

use App\Enums\ClienteTipo;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Cliente::class;
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'codigo_postal' => $this->faker->postcode(),
            'provincia_id' => Provincia::inRandomOrder()->first()->id,
            'vendedor_id' => User::role('responsable_de_zona')->inRandomOrder()->first()->id,
            'tipo' => $this->faker->randomElement(ClienteTipo::values()),
        ];
    }
}
