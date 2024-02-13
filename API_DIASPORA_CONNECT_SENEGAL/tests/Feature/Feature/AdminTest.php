<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_connexion_admin(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]); 
        $response->assertStatus(200);
    }

    public function test_user_can_logout()
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]); 
        $response = $this->post('/api/auth/logout');
        $this->assertGuest();
        $response->assertStatus(200);
    }

    public function test_bloquer_user(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->put('/api/user/bloquer/1');
        $response->assertStatus(200);   
    }

    public function test_debloquer_user(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->put('/api/user/debloquer/1');
        $response->assertStatus(200);   
    }

    public function test_liste_bloquer_user(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->get('/api/user/listeBloquer');
        $response->assertStatus(200);   
    }

    public function test_liste_debloquer_user(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com', 
            'password' => 'azertyuiop',
        ]);
        $response = $this->get('/api/user/listeDebloquer');
        // dd($response);
        $response->assertStatus(200);   
    }



    


}
