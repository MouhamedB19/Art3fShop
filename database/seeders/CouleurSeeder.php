<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Couleur;
class CouleurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $couleurs = [
            ['nom_couleur' => 'Rouge'],
            ['nom_couleur' => 'Bleu'],
            ['nom_couleur' => 'Vert'],
            ['nom_couleur' => 'Jaune'],
            ['nom_couleur' => 'Noir'],
            ['nom_couleur' => 'Blanc'],
            ['nom_couleur' => 'Orange'],
            ['nom_couleur' => 'Violet'],
            ['nom_couleur' => 'Rose'],
            ['nom_couleur' => 'Marron'],
        ];

        foreach($couleurs as $c) {
            Couleur::create($c);
        }
    }
}
