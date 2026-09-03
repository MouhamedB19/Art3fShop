<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_correct(): void
    {
        $response = $this->postJson('/api/login',[
            'email' => 'admin@art3f.test',
            'password' => 'TheChief0'
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_login_incorrect():void
    {
        $response = $this->postJson('api/login',[
            'email' => "marie.moreau@example.com",
            'password' => "password123",
        ]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_login_missing_informations():void
    {
        $responseEmpty = $this->postJson('api/login',[
            'email' => null,
            'password' => null,
        ]);

        $responseMissing = $this->postJson('api/login',[
            'email' => "marie.moreau@example.com"
        ]);

        $responseEmpty->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $responseMissing->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_login_unknown_person():void
    {
        $response = $this->postJson('api/login',[
            'email' => "dean.winchester@example.com",
            'password' => "password123"
        ]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
