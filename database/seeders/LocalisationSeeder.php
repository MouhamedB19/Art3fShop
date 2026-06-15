<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Localisation;
use App\Models\Ville;

class LocalisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Localisation::create([
            'code_postal' => '75001',
            'adresse'     => '12 rue des Arts',
            'ville_id'    => Ville::where('nom_ville','Paris')->first()->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        Localisation::create([
            'code_postal' => '69001',
            'adresse'     => '8 place Bellecour',
            'ville_id'    => Ville::where('nom_ville','Lyon')->first()->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        Localisation::create([
            'code_postal' => '13001',
            'adresse'     => '8 rue du Vieux-Port',
            'ville_id'    => Ville::where('nom_ville','Marseille')->first()->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        Localisation::create([
            'code_postal' => '1000',
            'adresse'     => '3 avenue Louise',
            'ville_id'    => Ville::where('nom_ville','Bruxelles')->first()->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        

    }
}
