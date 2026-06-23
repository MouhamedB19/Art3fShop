<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Localisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class ArtisteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artistes_data = [
            [
                'nom'               => 'Martin',
                'prenom'            => 'Sophie',
                'email'             => 'sophie.martin@art3f.test',
                'nom_d_artiste'     => 'SophieM',
                'bio'               => 'Peintre abstraite parisienne depuis 15 ans, Sophie Martin explore les émotions à travers les couleurs vives et les textures généreuses.',
                'Est_Artiste_Art3f' => true,
                'localisation_id'   => Localisation::where('code_postal', '75001')->first()->id,
            ],
            [
                'nom'               => 'Dubois',
                'prenom'            => 'Marc',
                'email'             => 'marc.dubois@art3f.test',
                'nom_d_artiste'     => 'MarcDubois',
                'bio'               => 'Sculpteur lyonnais spécialisé dans le bronze, Marc Dubois crée des œuvres figuratives d\'une grande sensibilité humaine.',
                'Est_Artiste_Art3f' => true,
                'localisation_id'   => Localisation::where('code_postal', '69001')->first()->id,
            ],
            
            [
                'nom'               => 'Bernard',
                'prenom'            => 'Thomas',
                'email'             => 'thomas.bernard@art3f.test',
                'nom_d_artiste'     => 'ThomasB',
                'bio'               => 'Peintre influencé par la Méditerranée et les arts primitifs, Thomas Bernard joue avec les contrastes et les textures.',
                'Est_Artiste_Art3f' => true,
                'localisation_id'   => Localisation::where('code_postal', '1000')->first()->id,
            ],
        ];
 
        foreach ($artistes_data as $data) {
            $user_id = DB::table('users')->insertGetId([
                'nom'        => $data['nom'],
                'prenom'     => $data['prenom'],
                'email'      => $data['email'],
                'password'   => Hash::make('password'),
                'role'       => 'artiste',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
 
            DB::table('artistes')->insertGetId([
                'user_id'           => $user_id,
                'nom_d_artiste'     => $data['nom_d_artiste'],
                'bio'               => $data['bio'],
                'photo'             => null,
                'Est_Artiste_Art3f' => $data['Est_Artiste_Art3f'],
                'iban'              => null,
                'CV'                => null,
                'localisations_id'  => $data['localisation_id'],
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
        $userAlaUne = DB::table("users")->insertGetId([
            'nom'               => 'Leroy',
            'prenom'            => 'Claire',
            'email'             => 'claire.leroy@art3f.test',
            'password'          => Hash::make("password"),
            'role'              => 'artiste',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        DB::table('artistes')->insertGetId([
            'user_id'           => $userAlaUne,
            'nom_d_artiste'     => 'ClaireL',
            'bio'               => 'Photographe marseillaise, Claire Leroy capture la lumière naturelle avec une précision et une poésie remarquables.',
            'a_la_une'          => true,
            'Est_Artiste_Art3f' => false,
            'localisations_id'   => Localisation::where('code_postal', '13001')->first()->id,
        ]);


        $this->command->info('✅ Artistes créés.');
    }
}
