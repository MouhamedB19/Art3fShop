<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pays;

class PaysSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $pays = [
            ['nom_pays' => 'France', 'devise' => 'EUR'],
            ['nom_pays' => 'Belgique', 'devise' => 'EUR'],
            ['nom_pays' => 'Suisse', 'devise' => 'CHF'],
            ['nom_pays' => 'Royaume-Uni', 'devise' => 'GBP'],
            ['nom_pays' => 'Allemagne', 'devise' => 'EUR'],
            ['nom_pays' => 'Espagne', 'devise' => 'EUR'],
            ['nom_pays' => 'Italie', 'devise' => 'EUR'],
        ];

        foreach($pays as $p) {
            Pays::create($p);
        }
    }
}
