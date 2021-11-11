<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_todos()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->getJson('api/todos');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "data" => [
                "*" =>  [
                    "id",
                    "created_at",
                    "updated_at",
                    "name",
                    "description",
                    "completed"
                ]
            ]
        ]);
    }
}
