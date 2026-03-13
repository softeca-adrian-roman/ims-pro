<?php

namespace Database\Factories;

use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehiculo>
 */
class VehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Vehiculo::class;
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word() . ' ' . $this->faker->randomLetter,
            'referencia' => strtoupper($this->faker->bothify('??####')),
            'stock' => $this->faker->numberBetween(0, 50),
        ];
    }
}
