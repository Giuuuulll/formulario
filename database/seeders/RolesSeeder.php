<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['nombre' => 'RRHH', 'email' => 'rrhh@empresa.com', 'rol' => 'rrhh'],
            ['nombre' => 'Auditoría', 'email' => 'auditoria@empresa.com', 'rol' => 'auditoria'],
            ['nombre' => 'TI', 'email' => 'ti@empresa.com', 'rol' => 'ti'],
            ['nombre' => 'Ciberseguridad', 'email' => 'ciber@empresa.com', 'rol' => 'ciber'],
        ];

        foreach ($roles as $r) {

            User::firstOrCreate(
                ['email' => $r['email']],
                [
                    'nombre'        => $r['nombre'],
                    'apellido'      => $r['nombre'],       // obligatorio → pongo algo genérico
                    'departamento'  => 'Sistemas',         // obligatorio
                    'puesto'        => 'Encargado',        // obligatorio
                    'empresa'       => 'ninguna',          // obligatorio según tu formulario
                    'password'      => Hash::make('12345678'),
                    'rol'           => $r['rol']
                ]
            );
        }
    }
}
