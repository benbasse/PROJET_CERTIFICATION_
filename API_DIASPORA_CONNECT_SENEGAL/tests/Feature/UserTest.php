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
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

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


}
