<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PaysSeeders;
use Database\Seeders\VillesSeeders;
use Database\Seeders\CategorieSeeder;
use Database\Seeders\SupportSeeder;
use Database\Seeders\ThemeSeeder;
use Database\Seeders\CouleurSeeder;
use Database\Seeders\OeuvreSeeder;
use Database\Seeders\ClientSeeder;
use Database\Seeders\CommandeSeeder;
use Database\Seeders\LocalisationSeeder;
use Database\Seeders\DimensionsSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PaysSeeders::class,
            VillesSeeders::class,
            LocalisationSeeder::class,
 
            // Référentiels
            ThemeSeeder::class,
            CouleurSeeder::class,
            DimensionsSeeder::class,
            CategorieSeeder::class,
 
            // Utilisateurs
            AdminSeeder::class,
            ArtisteSeeder::class,
            ClientSeeder::class,

 
            // Contenu
            OeuvreSeeder::class,
 
            // Commandes
            CommandeSeeder::class,
            
            //Coupons
            CouponsSeeders::class,
 
        ]);
    }
}