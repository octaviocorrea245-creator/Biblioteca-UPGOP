<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Libro;

class LibroTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_libro()
    {
        $libroData = [
            'titulo' => 'Libro de Prueba',
            'autor' => 'Autor de Prueba',
            'genero' => 'Ficción',
            'descripcion' => 'Una descripción de prueba',
            'isbn' => '978-1234567890',
            'cantidad_total' => 3
        ];

        $response = $this->postJson('/api/libros', $libroData);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'titulo' => 'Libro de Prueba',
                     'autor' => 'Autor de Prueba'
                 ]);

        $this->assertDatabaseHas('libros', [
            'titulo' => 'Libro de Prueba',
            'cantidad_disponible' => 3
        ]);
    }

    public function test_puede_obtener_lista_libros()
    {
        Libro::factory()->count(3)->create();

        $response = $this->getJson('/api/libros');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_puede_obtener_libro_por_id()
    {
        $libro = Libro::create([
            'titulo' => 'Libro Test',
            'autor' => 'Autor Test',
            'genero' => 'Test',
            'cantidad_total' => 1,
            'cantidad_disponible' => 1
        ]);

        $response = $this->getJson('/api/libros/' . $libro->id);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'titulo' => 'Libro Test'
                 ]);
    }

    public function test_puede_actualizar_libro()
    {
        $libro = Libro::create([
            'titulo' => 'Libro Original',
            'autor' => 'Autor Original',
            'genero' => 'Original',
            'cantidad_total' => 1,
            'cantidad_disponible' => 1
        ]);

        $datosActualizados = [
            'titulo' => 'Libro Actualizado',
            'autor' => 'Autor Actualizado',
            'genero' => 'Actualizado',
            'cantidad_total' => 2
        ];

        $response = $this->putJson('/api/libros/' . $libro->id, $datosActualizados);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'titulo' => 'Libro Actualizado'
                 ]);
    }

    public function test_valida_campos_requeridos()
    {
        $response = $this->postJson('/api/libros', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['titulo', 'autor', 'genero', 'cantidad_total']);
    }
}
