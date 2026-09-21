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
        $response = $responseArtiste->json();
        $token = $response['token'];
        $artisteId = $response['data']['artiste']['id'];
        $response = $this->withToken($token)->getJson("api/oeuvres/{$artisteId}");
        $response->assertStatus(200);
    }
}
