<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MaisonTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_create_a_maison(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->post('api/maison/create', [
            'addresse'=> 'Guediawaye',
            'superficie'=> 123,
            'prix'=> 1500000,
            'description'=> 0,
            'image'=> 'image.png',
            'annee_construction'=> 2020,
            'nombre_etage'=> 12,
            'categories_id'=> 1
        ]);
        $response->assertStatus(200);
    }

    public function test_update_a_maison(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->put('api/maison/edit/1', [
            'addresse'=> 'Guediawaye',
            'superficie'=> 123,
        ]);
        $response->assertStatus(200);      
    }

    public function test_delete_a_maison(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->delete('api/maison/supprimer/1');
        $response->assertStatus(200);
    }

    public function test_show_a_maison_with_id(): void
    {
        $response = $this->get('api/maison/detail/1');
        $response->assertStatus(200);
    }

    public function test_list_a_maison (): void
    {
        $response = $this->get('api/maison/liste');
        $response->assertStatus(200);
    }
}
