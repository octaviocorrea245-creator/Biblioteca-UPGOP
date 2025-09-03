<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $usuarios = [
            [
                'nombre' => 'Juan Perez',
                'email' => 'juan.perez@gmail.com',
                'telefono' => '+57 300 123 4567',
                'direccion' => 'Calle 123 #45-67, Bogotá',
                'activo' => true
            ],
            [
                'nombre' => 'Jojan Peña',
                'email' => 'jojanarza903@gmail.com',
                'telefono' => '+57 3184893875',
                'direccion' => 'Carrera 45 #12-34, Bogotá',
                'activo' => true
            ],
            [
                'nombre' => 'Carlos Rodriguez',
                'email' => 'carlos.rodriguez@gmail.com',
                'telefono' => '+57 302 345 6789',
                'direccion' => 'Avenida 68 #23-45, Bogotá',
                'activo' => true
            ],
            [
                'nombre' => 'Blanca ariza',
                'email' => 'blancacandy@gmail.com',
                'telefono' => '+57 303 456 7890',
                'direccion' => 'Calle 72 #11-22, Bogotá',
                'activo' => true
            ],
            [
                'nombre' => 'Luis Gonzalez',
                'email' => 'luis.gonzalez@gmail.com',
                'telefono' => '+57 304 567 8901',
                'direccion' => 'Carrera 15 #67-89, Bogotá',
                'activo' => false
            ]
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }
    }
}
