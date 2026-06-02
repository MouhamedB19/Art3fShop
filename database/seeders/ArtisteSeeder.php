<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artiste;
use App\Models\User;
class ArtisteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userArtistes = User::where('role','artiste')->get();
        foreach($userArtistes as $user){
            Artiste::create([
                'nom_d_artiste' => null,
                'bio' => 'Biographie de '.$user->prenom.' '.$user->nom,
                'photo' => 'photo.jpg',
                'Est_Artiste_Art3f' => true,
                'iban' => 'FR76',
                'CV' => 'cv.pdf',
                'user_id' => $user->id,
                'localisations_id' => null,
                
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
