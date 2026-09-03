<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_correcte(): void
    {
        $responseClient = $this->postJson('/api/register',[
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'acheteur'
        ]);

        $responseArtiste = $this->postJson('/api/register',[
            'nom' => 'Smith',
            'prenom' => 'Jane',
            'email' => 'jane.smith@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'artiste',
            'nom_d_artiste' => 'JaneSmithArt',
            'bio' => 'Nouvel artiste',
            'photo' => 'photos/jane_smith.jpg',
            'iban' => 'FR7630006000011234567890189',
            'a_la_une' => false,
            'Est_Artiste_Art3f' => false,
            'CV' => 'CVs/jane_smith_cv.pdf',
            'code_postal' => '75001',
            'adresse' => '123 Rue de l\'Art',
            'nom_ville' => 'Paris',
            'nom_pays' => "France",
        ]);

        $responseArtiste->assertStatus(201);
        $responseClient->assertStatus(201);
    }


    public function test_register_mail_deja_utilise(): void
    {
        $responseClient = $this->postJson('/api/register',[
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'acheteur'
        ]);
        $responseClient->assertStatus(422);
    }

    public function test_register_password_court():void
    {
        $response = $this->postJson('api/register',[
            'nom' => "Winchester",
            'prenom' => "Dean",
            'email' => "dean.winchester@example.com",
            'password' => "123",
            'password_confirmation' => "123",
            'role' => "acheteur"
        ]);
        $response->assertStatus(422);
    }

    public function test_register_password_mal_confirme():void
    {
        $responseMalConfirme = $this->postJson('api/register',[
            'nom' => "Winchester",
            'prenom' => "Dean",
            'email' => "dean.winchester@example.com",
            'password' => "password123",
            'password_confirmation' => "password",
            'role' => "acheteur"
        ]);

        $responseNonConfirme = $this->postJson('api/register',[
            'nom' => "Winchester",
            'prenom' => "Dean",
            'email' => "dean.winchester@example.com",
            'password' => "password123",
            'role' => "acheteur"
        ]);
        $responseMalConfirme->assertStatus(422);
        $responseNonConfirme->assertStatus(422);

    }

    public function test_register_email_invalide():void
    {
        $response = $this->postJson('api/register',[
            'nom' => "Winchester",
            'prenom' => "Dean",
            'email' => "dean.winchesterexample.com",
            'password' => "password123",
            'password_confirmation' => "password123",
            'role' => "acheteur"
        ]);
        $response->assertStatus(422);
    }

    public function test_register_champ_manquant():void
    {
        $response = $this->postJson('api/register',[
            'prenom' => "Dean",
            'email' => "dean.winchester@example.com",
            'password' => "password123",
            'password_confirmation' => "password123"
        ]);
        $response->assertStatus(422);
    }
}
