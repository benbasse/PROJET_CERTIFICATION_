<?php

namespace Tests\Feature\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DemandeServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_demande_service(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $user->currentAccessToken();
        $response = $this->post('/api/service/demande/create',[
            'users_id' => $user->id,
            'services_id'=> 1
        ]);
        $response->assertStatus(200);
    }

    public function test_liste_demande_service(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->get('/api/service/demande/liste');
        $response->assertStatus(200);
    }

    public function test_liste_demande_accepter_service(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->get('/api/service/demande/listeAccepter');
        $response->assertStatus(200);
    }

    public function test_liste_demande_refuser_service(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->get('/api/service/demande/listeRefuser');
        $response->assertStatus(200);
    }

    public function test_accepter_demande_service(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);  
        $response = $this->put('/api/service/demande/accepter/1',[
            'est_accepter'=> 'accepter'
        ]);
        $response->assertStatus(200);
    }

}
