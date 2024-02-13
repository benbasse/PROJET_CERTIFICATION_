<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_create_service(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $data = [
            'titre' => 'title 1',
            'description' => 'this is the description',
            'image' => UploadedFile::fake()->create('document.png'),
        ];
        $response = $this->post("api/service/create",$data);
        $response->assertStatus(200);
    }

    public function test_delete_service(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->delete('api/service/supprimer/1');
        $response->assertStatus(200);
    }
    
    public function test_show_service_with_id(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->get('api/service/detail/1');
        $response->assertStatus(200);
    }

    public function test_show_service_with_name(): void
    {
        
        $response = $this->get('api/service/detail/1');
        $response->assertStatus(200);
    }

    public function test_list_service(): void
    {
        $response = $this->get('api/service/liste');
        $response->assertStatus(200);
    }
}
