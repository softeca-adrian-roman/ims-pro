<?php

namespace Database\Seeders;

use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provincias = [
            'Burgos',
            'Madrid',
            'Valencia',
            'Barcelona',
            'Galicia',
        ];

        foreach ($provincias as $provincia) {
            Provincia::create(['nombre' => $provincia]);
        }
    }
}
