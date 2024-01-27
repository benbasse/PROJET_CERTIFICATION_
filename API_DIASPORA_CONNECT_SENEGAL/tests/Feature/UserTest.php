<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_can_register_user()
    {
        $userData = [
            'nom' => 'teste',
            'prenom' => 'teste',
            'image' => 'teste.png',
            'email' => 'teste@example.com',
            'password' => 'password',
            'telephone' => '+123456789'
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200);
    }

    public function test_can_login_user_with_email()
    {
        $userData = [
            'email' => 'musa@gmail.com',
            'password' => hash::make('password'),
        ];
        $response = $this->postJson('/api/auth/login', $userData);
        $response->assertStatus(200);

    }


    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response = $this->post('/api/auth/logout');
        $this->assertGuest();
        $response->assertStatus(200);
        // dump($response->json());
    }
}
