<?php

namespace Database\Seeders;

use App\Models\Artiste;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Dimension;
use App\Models\Oeuvre;
use App\Models\Support;
use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;


class OeuvreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oeuvres = [
            [
                'titre' => 'Coucher de soleil',
                'annee_de_creation' => 2020,
                'taux_reduction' => 0.15,
                'photo_principale' => 'coucher_soleil.jpg',
                'orientation' => 'paysage',
                'description' => 'Une peinture représentant un coucher de soleil.',
                'categorie_id' => 1,
                'support_id' => 1,
                'artiste_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Portrait d\'une inconnue',
                'annee_de_creation' => 2022,
                'taux_reduction' => null,
                'photo_principale' => 'portrait_inconnue.jpg',
                'orientation' => 'portrait',
                'description' => 'Portrait réaliste réalisé à l\'huile.',
                'categorie_id' => 2,
                'support_id' => 1,
                'artiste_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Composition abstraite',
                'annee_de_creation' => 2021,
                'taux_reduction' => 0.10,
                'photo_principale' => 'abstrait.jpg',
                'orientation' => 'carre',
                'description' => 'Œuvre abstraite aux formes géométriques.',
                'categorie_id' => 3,
                'support_id' => 2,
                'artiste_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach($oeuvres as $o){
            Oeuvre::create($o);
        }
    }
}


