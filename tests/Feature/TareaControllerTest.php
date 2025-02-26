<?php

namespace Tests\Feature;

use App\Models\Tarea;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TareaControllerTest extends TestCase
{
   use RefreshDatabase;

   public function test_obtener_tareas(): void
   {        
        //Preparación del escenario
        $tarea = Tarea::create([
            'id' => 10,
            'nombre' => 'Tarea 1',
            'descripcion' => 'Descripción de la tarea 1'
        ]); 

        //Realización de la acción
        $response = $this->getJson('/api/tareas');

        //Comprobación de la respuesta
        $response->assertStatus(200);
   }

    public function test_crear_tareas(): void
    {
        //Preparación del escenario
        $user = User::factory()->create();

        //Autenticación del usuario
        $this->actingAs($user);

        //Realización de la acción
        $response = $this->postJson('/api/tareas', [
            'nombre' => 'Tarea 1',
            'descripcion' => 'Descripción de la tarea 1',
            'estado' => '1'
        ]);

        // Comprobación de la respuesta
        $response->assertCreated(); //201
    }
    
}
