<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TemoignageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_temoignage(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);
        $user->currentAccessToken();
        $response = $this->post('/api/temoignage/create',[
            'users_id' => $user->id,
            'contenue'=> 'this is the temoignage'
        ]);
        $response->assertStatus(200);
    }

    public function test_accepter_temoignage(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);  
        $response = $this->put('/api/temoignage/accepter/1',[
            'status'=> 'accepter'
        ]);
        $response->assertStatus(200);
    }

    public function test_refuser_temoignage(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);  
        $response = $this->put('/api/temoignage/refuser/1',[
            'staut'=> 'accepter'
        ]);
        $response->assertStatus(200);
    }

    public function test_liste_accepter_temoignage(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);  
        $response = $this->get('/api/temoignage/liste/accepter');
        $response->assertStatus(200);
    }

    public function test_liste_refuser_temoignage(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);  
        $response = $this->get('/api/temoignage/liste/refuser');
        $response->assertStatus(200);
    }


    public function test_liste_en_attente_temoignage(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);  
        $response = $this->get('/api/temoignage/liste/enattente');
        $response->assertStatus(200);
    }
}
