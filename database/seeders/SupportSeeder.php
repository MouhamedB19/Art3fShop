<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Support;
class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $supports = [
            ['nom_support' => 'Toile sur châssis'],
            ['nom_support' => 'Toile libre'],
            ['nom_support' => 'Papier'],
            ['nom_support' => 'Bois'],
            ['nom_support' => 'Aluminium'],
            ['nom_support' => 'Plexiglas'],
            ['nom_support' => 'Bronze'],
            ['nom_support' => 'Marbre'],
            ['nom_support' => 'Résine'],
            ['nom_support' => 'Autre'],
        ];

        foreach($supports as $s) {
            Support::create($s);
        }
    }
}
