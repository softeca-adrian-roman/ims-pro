<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            'ver clientes',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'ver vehiculos',
            'crear vehiculos',
            'editar vehiculos',
            'eliminar vehiculos',
            'ver vendedores',
            'crear vendedores',
            'editar vendedores',
            'eliminar vendedores',
            'asignar vehiculos',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name'=>$permiso]);
        }

        $rolAdmin = Role::firstOrCreate(['name'=> 'admin']);
        $rolAdmin->syncPermissions($permisos);

        $rolResponsable = Role::firstOrCreate(['name'=> 'responsable_de_zona']);
        $rolResponsable->syncPermissions([
            'ver clientes',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'ver vehiculos',
            'asignar vehiculos',
        ]);
    }
}
