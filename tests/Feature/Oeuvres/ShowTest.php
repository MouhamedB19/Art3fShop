<?php

namespace Tests\Feature\Oeuvres;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ShowTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_oeuvre_show(): void
    {
        $responseArtiste = $this->postJson('api/login', [
            'email' => 'claire.leroy@art3f.test',
            'password' => 'password'
        ]);
        $token = $responseArtiste->json('token');
        $id = $responseArtiste->json('id');
        $response = $this->withToken($token)->getJson("api/oeuvres/{$id}");
        $response->assertStatus(200);
    }
}
