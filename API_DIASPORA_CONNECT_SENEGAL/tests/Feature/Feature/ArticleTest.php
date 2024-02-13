<?php

namespace Tests\Feature\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     */


    public function test_create_articles(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->post('api/article/create', [
            'titre'=> 'article 1',
            'description'=> 'this is the description',
            'image'=> UploadedFile::fake()->create('image.png'),
        ]);
        $response->assertStatus(200);
    }

    public function test_update_article(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->put('api/article/edit/1', [
            'titre'=> 'article 1',
            'description'=> 'this is the description',
            'image'=> UploadedFile::fake()->create('image.png'),
        ]);
        $response->assertStatus(200);
    }

    public function test_delete_article(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'azertyuiop',
        ]);
        $response = $this->delete('api/article/supprimer/1');
        // dd($response);
        $response->assertStatus(200);
    }

    public function test_show_article_with_id(): void
    {
        $response = $this->get('api/article/detail/1');
        $response->assertStatus(200);
    }

    public function test_list_article (): void
    {
        $response = $this->get('api/article/liste');
        $response->assertStatus(200);
    }
}
