<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {
        $response = $this->postJson('/api/login',[
            'email' => 'admin@art3f.test',
            'password' => 'TheAdmin68'
        ]);
        $response->assertStatus(200);
    }
}
