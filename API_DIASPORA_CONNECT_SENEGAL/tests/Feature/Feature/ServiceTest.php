<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_create_service(): void
    {
        $response = $this->post('api/service/create', [
            'titre'=> 'title 1',
            'description'=> 'this is the description',
            'image'=> 'image.png',
        ]);
        $response->assertStatus(200);
    }

    public function test_delete_service(): void
    {
        $response = $this->delete('api/service/supprimer/1');
        $response->assertStatus(200);
    }
    
    public function test_show_service_with_id(): void
    {
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
