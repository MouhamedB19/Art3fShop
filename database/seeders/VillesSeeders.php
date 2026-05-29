<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ville;
class VillesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $villes = [
            // France
            ['nom_ville' => 'Paris', 'pays_id' => 1],
            ['nom_ville' => 'Lyon', 'pays_id' => 1],
            ['nom_ville' => 'Marseille', 'pays_id' => 1],
            ['nom_ville' => 'Mulhouse', 'pays_id' => 1],
            ['nom_ville' => 'Strasbourg', 'pays_id' => 1],
            // Belgique
            ['nom_ville' => 'Bruxelles', 'pays_id' => 2],
            ['nom_ville' => 'Liège', 'pays_id' => 2],
            // Suisse
            ['nom_ville' => 'Genève', 'pays_id' => 3],
            ['nom_ville' => 'Zürich', 'pays_id' => 3],
            // Royaume-Uni
            ['nom_ville' => 'Londres', 'pays_id' => 4],
            ['nom_ville' => 'Manchester', 'pays_id' => 4],
        ];

        foreach($villes as $v) {
            Ville::create($v);
        }
    }
}
