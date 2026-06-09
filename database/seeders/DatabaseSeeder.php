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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            
            ThemeSeeder::class,
            CouleurSeeder::class,
 
        ]);
        /*****************************************************************************
         * ***********************User************************************************
         * ***************************************************************************
         */
        DB::table('users')->insert([
            [
                'nom'        => 'Dupont',
                'prenom'     => 'Jean',
                'email'      => 'client@art3f.test',
                'password'   => Hash::make('password'),
                'role'       => 'acheteur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom'        => 'Ba',
                'prenom'     => 'Mouhamed',
                'email'      => 'admin@art3f.test',
                'password'   => Hash::make('Yo Angelo'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        /*****************************************************************************
         * ******************Localisation*********************************************
         * ***************************************************************************
         */
        $loc_paris = DB::table('localisations')->insertGetId([
            'code_postal' => '75001',
            'adresse'     => '12 rue des Arts',
            'ville_id'    => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
 
        $loc_lyon = DB::table('localisations')->insertGetId([
            'code_postal' => '69001',
            'adresse'     => '8 place Bellecour',
            'ville_id'    => 2,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
 
        $loc_marseille = DB::table('localisations')->insertGetId([
            'code_postal' => '13001',
            'adresse'     => '5 rue du Vieux-Port',
            'ville_id'    => 3,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
 
        $loc_bruxelles = DB::table('localisations')->insertGetId([
            'code_postal' => '1000',
            'adresse'     => '3 avenue Louise',
            'ville_id'    => 6,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        /*****************************************************************************
         * **********************Artistes*********************************************
         * ***************************************************************************
         */
        $artistes_data = [
            [
                'nom'            => 'Martin',
                'prenom'         => 'Sophie',
                'email'          => 'sophie.martin@art3f.test',
                'nom_d_artiste'  => 'SophieM',
                'bio'            => 'Peintre abstraite parisienne depuis 15 ans, Sophie Martin explore les émotions à travers les couleurs vives et les textures généreuses.',
                'Est_Artiste_Art3f' => true,
                'localisation_id'=> $loc_paris,
            ],
            [
                'nom'            => 'Dubois',
                'prenom'         => 'Marc',
                'email'          => 'marc.dubois@art3f.test',
                'nom_d_artiste'  => 'MarcDubois',
                'bio'            => 'Sculpteur lyonnais spécialisé dans le bronze, Marc Dubois crée des œuvres figuratives d\'une grande sensibilité humaine.',
                'Est_Artiste_Art3f' => true,
                'localisation_id'=> $loc_lyon,
            ],
            [
                'nom'            => 'Leroy',
                'prenom'         => 'Claire',
                'email'          => 'claire.leroy@art3f.test',
                'nom_d_artiste'  => 'ClaireL',
                'bio'            => 'Photographe marseillaise, Claire Leroy capture la lumière naturelle avec une précision et une poésie remarquables.',
                'Est_Artiste_Art3f' => false,
                'localisation_id'=> $loc_marseille,
            ],
            [
                'nom'            => 'Bernard',
                'prenom'         => 'Thomas',
                'email'          => 'thomas.bernard@art3f.test',
                'nom_d_artiste'  => 'ThomasB',
                'bio'            => 'Peintre influencé par la Méditerranée et les arts primitifs, Thomas Bernard joue avec les contrastes et les textures.',
                'Est_Artiste_Art3f' => true,
                'localisation_id'=> $loc_bruxelles,
            ],
        ];
 
        $artiste_ids = [];
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
 
            $artiste_ids[] = DB::table('artistes')->insertGetId([
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

        /*****************************************************************************
         * ******************Support**************************************************
         * ***************************************************************************
         */
        
        $supports = [
            'Toile sur châssis',
            'Toile libre',
            'Papier',
            'Bois',
            'Aluminium',
            'Plexiglas',
            'Marbre',
            'Bronze',
            'Résine',
        ];
 
        foreach ($supports as $support) {
            DB::table('supports')->insert([
                'nom_support' => $support,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
 
        /*****************************************************************************
         * *********************Catégories********************************************
         * ***************************************************************************
         */
        $peinture_id = DB::table('categories')->insertGetId([
            'nom_categorie'       => 'Peinture',
            'nom_technique'       => null,
            'description_courte' => 'Œuvres réalisées à l\'aide de pigments appliqués sur une surface.',
            'description_longue' => 'La peinture est une forme d\'art visuel qui utilise des pigments pour créer des images sur divers supports. Elle peut être réalisée avec différentes techniques telles que l\'huile, l\'acrylique ou l\'aquarelle, offrant une grande variété de styles et d\'expressions artistiques.',
            'id_categorie_parente' => null,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
 
        $sculpture_id = DB::table('categories')->insertGetId([
            'nom_categorie'       => 'Sculpture',
            'nom_technique'       => null,
            'description_courte' => 'Œuvres en trois dimensions créées par modelage, taille ou assemblage.',
            'description_longue' => 'La sculpture est une forme d\'art tridimensionnelle qui consiste à créer des œuvres en modelant, taillant ou assemblant des matériaux tels que le bois, la pierre, le métal ou la résine. Les sculptures peuvent être figuratives ou abstraite.',
            'id_categorie_parente' => null,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
 
        $photo_id = DB::table('categories')->insertGetId([
            'nom_categorie'       => 'Photographie',
            'nom_technique'       => null,
            'description_courte' => 'Œuvres créées à l\'aide d\'un appareil photo capturant la lumière.',
            'description_longue' => 'La photographie est une forme d\'art qui utilise la lumière pour capturer des images à l\'aide d\'un appareil photo.',
            'id_categorie_parente' => null,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
 
        DB::table('categories')->insertGetId([
            'nom_categorie'       => 'Édition',
            'nom_technique'       => null,
            'description_courte' => 'Œuvres produites en série limitée à partir d\'une matrice originale.',
            'description_longue' => 'L\'édition est une forme d\'art qui consiste à produire des œuvres en série limitée à partir d\'une matrice originale, comme une gravure ou une lithographie. Chaque tirage est numéroté et signé par l\'artiste.',
            'id_categorie_parente' => null,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
 
        DB::table('categories')->insertGetId([
            'nom_categorie'       => 'Dessin',
            'nom_technique'       => null,
            'description_courte' => 'Œuvres réalisées à l\'aide de crayons, fusains ou encres.',
            'description_longue' => 'Le dessin est une forme d\'art qui utilise des outils tels que des crayons, des fusains ou des encres pour créer des images sur du papier.',
            'id_categorie_parente' => null,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
 
        // Sous-catégories
        DB::table('categories')->insert([
            ['nom_categorie' => 'Peinture à l\'huile', 'nom_technique' => 'Huile sur toile',     'id_categorie_parente' => $peinture_id,  'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Peinture acrylique',  'nom_technique' => 'Acrylique sur toile', 'id_categorie_parente' => $peinture_id,  'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Aquarelle',           'nom_technique' => 'Aquarelle sur papier','id_categorie_parente' => $peinture_id,  'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Sculpture bronze',    'nom_technique' => 'Bronze',              'id_categorie_parente' => $sculpture_id, 'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Sculpture résine',    'nom_technique' => 'Résine',              'id_categorie_parente' => $sculpture_id, 'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Photo argentique',    'nom_technique' => 'Argentique',          'id_categorie_parente' => $photo_id,     'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Photo numérique',     'nom_technique' => 'Numérique',           'id_categorie_parente' => $photo_id,     'created_at' => now(), 'updated_at' => now()],
        ]);

        $categoriesArtistes = [[1,1],[2,2],[3,3],[4,1]];
        foreach($categoriesArtistes as [$art,$cat])
        {
            DB::table('artiste_categorie')->insertGetId([
                'artiste_id' => $art,
                'categorie_id' => $cat,
                
            ]);
        }
 
        /*****************************************************************************
         * ***********************Dimensions******************************************
         * ***************************************************************************
         */
        $dims = [
            [30,30],[40,40],[50,50],[60,60],[80,80],[100,100],
            [40,60],[50,70],[60,80],[80,100],[100,120],[100,150],
            [60,40],[80,60],[120,80],
        ];
 
        $dim_ids = [];
        foreach ($dims as [$h, $l]) {
            $dim_ids[] = DB::table('dimensions')->insertGetId([
                'hauteur'    => $h,
                'largeur'    => $l,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        /*****************************************************************************
         * ********************Oeuvres************************************************
         * ***************************************************************************
         */
        $oeuvres = [
            // Sophie Martin — Peinture
            ['titre' => 'Éclat de lumière',       'annee_de_creation' => 2023, 'orientation' => 'carre',    'cat' => $peinture_id,  'support' => 1, 'artiste' => 0, 'reduction' => null, 'visible' => true,  'prix' => 850,  'status' => 'disponible', 'dim' => 4],
            ['titre' => 'Vague intérieure',        'annee_de_creation' => 2022, 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 0, 'reduction' => null, 'visible' => true,  'prix' => 1200, 'status' => 'disponible', 'dim' => 9],
            ['titre' => 'Rouge passion',           'annee_de_creation' => 2024, 'orientation' => 'portrait', 'cat' => $peinture_id,  'support' => 2, 'artiste' => 0, 'reduction' => 0.20, 'visible' => true,  'prix' => 650,  'status' => 'disponible', 'dim' => 7],
            ['titre' => 'Silence bleu',            'annee_de_creation' => 2021, 'orientation' => 'carre',    'cat' => $peinture_id,  'support' => 1, 'artiste' => 0, 'reduction' => null, 'visible' => true,  'prix' => 950,  'status' => 'vendu',      'dim' => 5],
            ['titre' => 'Horizon doré',            'annee_de_creation' => 2024, 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 0, 'reduction' => null, 'visible' => true,  'prix' => 1450, 'status' => 'disponible', 'dim' => 10],
 
            // Marc Dubois — Sculpture
            ['titre' => 'L\'éveil',               'annee_de_creation' => 2022, 'orientation' => 'portrait', 'cat' => $sculpture_id, 'support' => 8, 'artiste' => 1, 'reduction' => null, 'visible' => true,  'prix' => 3200, 'status' => 'disponible', 'dim' => 3],
            ['titre' => 'Force tranquille',        'annee_de_creation' => 2023, 'orientation' => 'portrait', 'cat' => $sculpture_id, 'support' => 8, 'artiste' => 1, 'reduction' => null, 'visible' => true,  'prix' => 4500, 'status' => 'disponible', 'dim' => 6],
            ['titre' => 'Fusion',                  'annee_de_creation' => 2021, 'orientation' => 'carre',    'cat' => $sculpture_id, 'support' => 9, 'artiste' => 1, 'reduction' => 0.15, 'visible' => true,  'prix' => 2100, 'status' => 'disponible', 'dim' => 2],
            ['titre' => 'Le gardien',              'annee_de_creation' => 2020, 'orientation' => 'portrait', 'cat' => $sculpture_id, 'support' => 8, 'artiste' => 1, 'reduction' => null, 'visible' => false, 'prix' => 5800, 'status' => 'vendu',      'dim' => 8],
 
            // Claire Leroy — Photographie
            ['titre' => 'Brume matinale',          'annee_de_creation' => 2023, 'orientation' => 'paysage',  'cat' => $photo_id,     'support' => 5, 'artiste' => 2, 'reduction' => null, 'visible' => true,  'prix' => 480,  'status' => 'disponible', 'dim' => 9],
            ['titre' => 'Reflets urbains',         'annee_de_creation' => 2024, 'orientation' => 'portrait', 'cat' => $photo_id,     'support' => 6, 'artiste' => 2, 'reduction' => null, 'visible' => true,  'prix' => 620,  'status' => 'disponible', 'dim' => 7],
            ['titre' => 'L\'instant suspendu',     'annee_de_creation' => 2022, 'orientation' => 'carre',    'cat' => $photo_id,     'support' => 5, 'artiste' => 2, 'reduction' => 0.10, 'visible' => true,  'prix' => 390,  'status' => 'disponible', 'dim' => 4],
            ['titre' => 'Lumière rasante',         'annee_de_creation' => 2023, 'orientation' => 'paysage',  'cat' => $photo_id,     'support' => 5, 'artiste' => 2, 'reduction' => null, 'visible' => true,  'prix' => 750,  'status' => 'vendu',      'dim' => 11],
 
            // Thomas Bernard — Peinture
            ['titre' => 'Calanque bleue',          'annee_de_creation' => 2024, 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 3, 'reduction' => null, 'visible' => true,  'prix' => 1100, 'status' => 'disponible', 'dim' => 10],
            ['titre' => 'Marché provençal',        'annee_de_creation' => 2023, 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 3, 'reduction' => null, 'visible' => true,  'prix' => 890,  'status' => 'disponible', 'dim' => 9],
            ['titre' => 'Soleil couchant',         'annee_de_creation' => 2022, 'orientation' => 'carre',    'cat' => $peinture_id,  'support' => 2, 'artiste' => 3, 'reduction' => 0.25, 'visible' => true,  'prix' => 720,  'status' => 'disponible', 'dim' => 5],
            ['titre' => 'Mistral',                 'annee_de_creation' => 2024, 'orientation' => 'portrait', 'cat' => $peinture_id,  'support' => 1, 'artiste' => 3, 'reduction' => null, 'visible' => true,  'prix' => 980,  'status' => 'disponible', 'dim' => 8],
            ['titre' => 'Nuit étoilée du sud',     'annee_de_creation' => 2021, 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 3, 'reduction' => null, 'visible' => true,  'prix' => 1350, 'status' => 'vendu',      'dim' => 11],
        ];
 
        foreach ($oeuvres as $o) {
            $created = Carbon::now()->subDays(rand(1, 90));
 
            $oeuvre_id = DB::table('oeuvres')->insertGetId([
                'titre'             => $o['titre'],
                'annee_de_creation' => $o['annee_de_creation'],
                'taux_reduction'    => $o['reduction'],
                'photo_principale'  => 'oeuvres/placeholder.jpg',
                'orientation'       => $o['orientation'],
                'description'       => 'Une œuvre remarquable qui témoigne du talent et de la sensibilité de l\'artiste.',
                'categorie_id'      => $o['cat'],
                'support_id'        => $o['support'],
                'artiste_id'        => $artiste_ids[$o['artiste']],
                'visible'           => $o['visible'],
                 'created_at'        => $created,
                'updated_at'        => $created,
            ]);
            DB::table('tirages')->insert([
                'oeuvre_id'        => $oeuvre_id,
                'numero'           => 1,
                'status'           => $o['status'],
                'prix'             => $o['prix'],
                'encadrement'      => rand(0, 1),
                'pret_a_accrocher' => rand(0, 1),
                'dimensions_id'    => $dim_ids[$o['dim']],
                'commandes_id'     => null,
                'avec_cadre'       => rand(0, 1),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }



        /*****************************************************************************
         * ****************Association thèmes-couleurs********************************
         * ***************************************************************************
         */
        $themes  = DB::table('themes')->pluck('id', 'nom_theme');
        $couleurs = DB::table('couleurs')->pluck('id', 'nom_couleur');

        // Récupère les œuvres qu'on vient de créer
        $oeuvres_ids = DB::table('oeuvres')->pluck('id')->toArray();

        // Association thèmes/couleurs par œuvre
        $associations = [
            // Éclat de lumière
            0  => ['themes' => ['Abstrait'],              'couleurs' => ['Rouge', 'Orange', 'Jaune']],
            // Vague intérieure
            1  => ['themes' => ['Mer', 'Abstrait'],        'couleurs' => ['Bleu', 'Blanc']],
            // Rouge passion
            2  => ['themes' => ['Abstrait'],               'couleurs' => ['Rouge', 'Noir']],
            // Silence bleu
            3  => ['themes' => ['Abstrait'],               'couleurs' => ['Bleu', 'Blanc']],
            // Horizon doré
            4  => ['themes' => ['Paysage'],                'couleurs' => ['Jaune', 'Orange']],
            // L'éveil
            5  => ['themes' => ['Portrait'],               'couleurs' => ['Marron', 'Noir']],
            // Force tranquille
            6  => ['themes' => ['Portrait', 'Femme'],      'couleurs' => ['Marron', 'Noir']],
            // Fusion
            7  => ['themes' => ['Abstrait'],               'couleurs' => ['Rouge', 'Noir', 'Blanc']],
            // Le gardien
            8  => ['themes' => ['Portrait'],               'couleurs' => ['Marron', 'Noir']],
            // Brume matinale
            9  => ['themes' => ['Paysage', 'Nature morte'],'couleurs' => ['Blanc', 'Bleu']],
            // Reflets urbains
            10 => ['themes' => ['Urbain'],                 'couleurs' => ['Noir', 'Blanc']],
            // L'instant suspendu
            11 => ['themes' => ['Portrait', 'Femme'],      'couleurs' => ['Marron', 'Rose']],
            // Lumière rasante
            12 => ['themes' => ['Paysage'],                'couleurs' => ['Jaune', 'Orange']],
            // Calanque bleue
            13 => ['themes' => ['Mer', 'Paysage'],         'couleurs' => ['Bleu', 'Vert']],
            // Marché provençal
            14 => ['themes' => ['Urbain', 'Paysage'],      'couleurs' => ['Orange', 'Jaune', 'Rouge']],
            // Soleil couchant
            15 => ['themes' => ['Paysage'],                'couleurs' => ['Orange', 'Rouge', 'Jaune']],
            // Mistral
            16 => ['themes' => ['Paysage', 'Abstrait'],    'couleurs' => ['Bleu', 'Blanc']],
            // Nuit étoilée du sud
            17 => ['themes' => ['Paysage'],                'couleurs' => ['Bleu', 'Violet', 'Noir']],
        ];

        foreach ($associations as $index => $assoc) {
            $oeuvre_id = $oeuvres_ids[$index];

            // Thèmes
            foreach ($assoc['themes'] as $nom_theme) {
                DB::table('oeuvre_theme')->insert([
                    'oeuvre_id' => $oeuvre_id,
                    'theme_id'  => $themes[$nom_theme],
                ]);
            }

            // Couleurs
            foreach ($assoc['couleurs'] as $nom_couleur) {
                DB::table('oeuvre_couleur')->insert([
                    'oeuvre_id'  => $oeuvre_id,
                    'couleur_id' => $couleurs[$nom_couleur],
                ]);
            }
        }
 
        
        
    }
}