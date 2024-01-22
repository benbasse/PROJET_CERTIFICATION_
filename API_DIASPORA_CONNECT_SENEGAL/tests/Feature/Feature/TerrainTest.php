<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TerrainTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_create_a_terrain(): void
    {
        $response = $this->post('api/terrain/create', [
            'addresse'=> 'Guediawaye',
            'superficie'=> 12000,
            'prix'=> 5000000,
            'description'=> 'this is the description',
            'image' => 'image.png',
            'type_terrain'=> 'angle',
        ]);
        $response->assertStatus(200);

    }

    public function test_update_a_terrain(): void
    {
        $response = $this->put('api/terrain/edit/1', [
            'addresse'=> 'Guediawaye',
            'superficie'=> 12000,
            'prix'=> 5000000,
            'description'=> 'this is the description',
            'image' => 'image.png',
            'type_terrain'=> 'angle',
        ]);
        $response->assertStatus(200);

    }

    public function test_delete_a_terrain(): void
    {
        $response = $this->delete('api/terrain/supprimer/1');
        $response->assertStatus(200);
    }

    public function test_show_a_terrain_by_id(): void
    {
        $response = $this->get('api/terrain/detail/1');
        $response->assertStatus(200);
    }

    public function test_list_terrain(): void
    {
        $response = $this->get('api/terrain/liste');
        $response->assertStatus(200); 
    }
}
