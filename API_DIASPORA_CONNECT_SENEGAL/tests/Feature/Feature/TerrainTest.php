<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TerrainTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_create_a_terrain(): void
    {
        $user = User::factory()->create();
        $response = $this->post("/api/auth/login", [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $data = [
            'addresse'=> 'Guediawaye',
            'superficie'=> 12000,
            'prix'=> 5000000,
            'description'=> 'this is the description',
            'image' => UploadedFile::fake()->create('document.png'),
        ];
        $response = $this->post('api/terrain/create', $data);
        // dd($response);
        $response->assertStatus(200);

    }

    public function test_update_a_terrain(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $data = [
            'addresse'=> 'Guediawaye',
            'superficie'=> 12000,
            'prix'=> 5000000,
            'description'=> 'this is the description'
        ];
        $response = $this->put('api/terrain/edit/1', $data);
        $response->assertStatus(200);

    }

    public function test_delete_a_terrain(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
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
