<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(3),
            'autor' => fake()->name(),
            'genero' => fake()->randomElement(['Ficción', 'No Ficción', 'Ciencia', 'Historia', 'Romance']),
            'descripcion' => fake()->paragraph(),
            'isbn' => fake()->isbn13(),
            'cantidad_total' => fake()->numberBetween(1, 10),
            'cantidad_disponible' => function (array $attributes) {
                return $attributes['cantidad_total'];
            }
        ];
    }
}
