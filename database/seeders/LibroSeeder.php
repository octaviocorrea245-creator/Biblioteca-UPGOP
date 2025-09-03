<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibroSeeder extends Seeder
{
    public function run()
    {
        $libros = [
            [
                'titulo' => 'Cien años de soledad',
                'autor' => 'Gabriel García Márquez',
                'genero' => 'Realismo mágico',
                'descripcion' => 'Una obra maestra de la literatura latinoamericana',
                'isbn' => '978-0307389732',
                'cantidad_total' => 3,
                'cantidad_disponible' => 3
            ],
            [
                'titulo' => 'Don Quijote de la Mancha',
                'autor' => 'Miguel de Cervantes',
                'genero' => 'Clásico',
                'descripcion' => 'La historia del ingenioso hidalgo',
                'isbn' => '978-8424116231',
                'cantidad_total' => 2,
                'cantidad_disponible' => 2
            ],
            [
                'titulo' => '1984',
                'autor' => 'George Orwell',
                'genero' => 'Distopía',
                'descripcion' => 'Una novela sobre el totalitarismo',
                'isbn' => '978-0451524935',
                'cantidad_total' => 4,
                'cantidad_disponible' => 4
            ],
            [
                'titulo' => 'El amor en los tiempos del cólera',
                'autor' => 'Gabriel García Márquez',
                'genero' => 'Romance',
                'descripcion' => 'Una historia de amor que trasciende el tiempo',
                'isbn' => '978-0307389733',
                'cantidad_total' => 2,
                'cantidad_disponible' => 2
            ],
            [
                'titulo' => 'Harry Potter y la piedra filosofal',
                'autor' => 'J.K. Rowling',
                'genero' => 'Fantasía',
                'descripcion' => 'El comienzo de la saga del joven mago',
                'isbn' => '978-0439708180',
                'cantidad_total' => 5,
                'cantidad_disponible' => 5
            ],
            [
                'titulo' => 'El principito',
                'autor' => 'Antoine de Saint-Exupéry',
                'genero' => 'Infantil',
                'descripcion' => 'Una fábula sobre la amistad y el amor',
                'isbn' => '978-0156012195',
                'cantidad_total' => 3,
                'cantidad_disponible' => 3
            ]
        ];

        foreach ($libros as $libro) {
            Libro::create($libro);
        }
    }
}
