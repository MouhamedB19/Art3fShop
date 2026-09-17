<?php

namespace Tests\Feature\Oeuvres;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factory;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_oeuvres_index(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
