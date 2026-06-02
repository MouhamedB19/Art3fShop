<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PaysSeeders;
use Database\Seeders\VillesSeeders;
use Database\Seeders\CategorieSeeder;
use Database\Seeders\SupportSeeder;
use Database\Seeders\ThemeSeeder;
use Database\Seeders\CouleurSeeder;
use Database\Seeders\OeuvreSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            PaysSeeders::class,
            VillesSeeders::class,
            CategorieSeeder::class,
            SupportSeeder::class,
            ThemeSeeder::class,
            CouleurSeeder::class,
            UserSeeder::class,
            ArtisteSeeder::class,
            OeuvreSeeder::class,
            
        ]);
        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
