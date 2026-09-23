<?php

namespace Tests\Feature\Oeuvres;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ShowTest extends TestCase
{
    /**
     * A modifier au plus vite (adaptation aux nouvelles routes)
     */

    public function test_oeuvre_show_artiste(): void
    {
        $response = $this->get('/api/oeuvres/oeuvre/1');
        $response->assertStatus(200);
    }
}
