<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Theme;
class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $themes = [
            ['nom_theme' => 'Animaux'],
            ['nom_theme' => 'Mer'],
            ['nom_theme' => 'Paysage'],
            ['nom_theme' => 'Portrait'],
            ['nom_theme' => 'Femme'],
            ['nom_theme' => 'Abstrait'],
            ['nom_theme' => 'Nature morte'],
            ['nom_theme' => 'Nu'],
            ['nom_theme' => 'Urbain'],
            ['nom_theme' => 'Floral'],
        ];
    
        foreach($themes as $t) {
            Theme::create($t);
        }
    }
}
