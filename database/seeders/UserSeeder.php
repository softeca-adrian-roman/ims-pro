<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'name' => 'Adrián Román Porras',
            'email' => 'adrian.roman@softeca.es',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole(['admin']);

        $responsable = User::firstOrCreate([
            'name' => 'David Soto Garcia',
            'email' => 'david.soto@softeca.es',
            'password' => bcrypt('12345678'),
        ]);
    $responsable->assignRole(['responsable_de_zona']);

        User::factory(10)->create()->each(function (User $user) {
            $user->assignRole(['responsable_de_zona']);
        });
    }
}
