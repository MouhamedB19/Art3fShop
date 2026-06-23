<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Artiste;

class OeuvreSeeder extends Seeder
{
    public function run(): void
    {
        $artiste_ids = DB::table('artistes')->orderBy('id')->pluck('id')->toArray();
        $dim_ids     = DB::table('dimensions')->orderBy('id')->pluck('id')->toArray();
        $categories  = DB::table('categories')->whereNull('id_categorie_parente')->pluck('id', 'nom_categorie');

        $peinture_id  = $categories['Peinture'];
        $sculpture_id = $categories['Sculpture'];
        $photo_id     = $categories['Photographie'];

        $oeuvres = [
            // Sophie Martin — Peinture
            ['titre' => 'Éclat de lumière',    'annee' => 2023, 'photo_principale' => null,'orientation' => 'carre',    'cat' => $peinture_id,  'support' => 1, 'artiste' => 0, 'reduction' => null, 'visible' => true,  'prix' => 850,  'status' => 'disponible', 'dim' => 4],
            ['titre' => 'Vague intérieure',     'annee' => 2022,'photo_principale' => null, 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 0, 'reduction' => null, 'visible' => true,  'prix' => 1200, 'status' => 'disponible', 'dim' => 9],
            ['titre' => 'Rouge passion',        'annee' => 2024,'photo_principale' => null, 'orientation' => 'portrait', 'cat' => $peinture_id,  'support' => 2, 'artiste' => 0, 'reduction' => 0.20, 'visible' => true,  'prix' => 650,  'status' => 'disponible', 'dim' => 7],
            ['titre' => 'Silence bleu',         'annee' => 2021,'photo_principale' => null, 'orientation' => 'carre',    'cat' => $peinture_id,  'support' => 1, 'artiste' => 0, 'reduction' => null, 'visible' => true,  'prix' => 950,  'status' => 'vendu',      'dim' => 5],
            ['titre' => 'Horizon doré',         'annee' => 2024,'photo_principale' => null, 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 0, 'reduction' => null, 'visible' => true,  'prix' => 1450, 'status' => 'disponible', 'dim' => 10],
            // Marc Dubois — Sculpture
            ['titre' => 'L\'éveil',            'annee' => 2022, 'photo_principale' => null,'orientation' => 'portrait', 'cat' => $sculpture_id, 'support' => 8, 'artiste' => 1, 'reduction' => null, 'visible' => true,  'prix' => 3200, 'status' => 'disponible', 'dim' => 3],
            ['titre' => 'Force tranquille',     'annee' => 2023,'photo_principale' => null, 'orientation' => 'portrait', 'cat' => $sculpture_id, 'support' => 8, 'artiste' => 1, 'reduction' => null, 'visible' => true,  'prix' => 4500, 'status' => 'disponible', 'dim' => 6],
            ['titre' => 'Fusion',               'annee' => 2021,'photo_principale' => null, 'orientation' => 'carre',    'cat' => $sculpture_id, 'support' => 9, 'artiste' => 1, 'reduction' => 0.15, 'visible' => true,  'prix' => 2100, 'status' => 'disponible', 'dim' => 2],
            ['titre' => 'Le gardien',           'annee' => 2020,'photo_principale' => null, 'orientation' => 'portrait', 'cat' => $sculpture_id, 'support' => 8, 'artiste' => 1, 'reduction' => null, 'visible' => false, 'prix' => 5800, 'status' => 'vendu',      'dim' => 8],
            // Thomas Bernard — Photographie
            ['titre' => 'Brume matinale',       'annee' => 2023,'photo_principale' => null, 'orientation' => 'paysage',  'cat' => $photo_id,     'support' => 5, 'artiste' => 2, 'reduction' => null, 'visible' => true,  'prix' => 480,  'status' => 'disponible', 'dim' => 9],
            ['titre' => 'Reflets urbains',      'annee' => 2024,'photo_principale' => null, 'orientation' => 'portrait', 'cat' => $photo_id,     'support' => 6, 'artiste' => 2, 'reduction' => null, 'visible' => true,  'prix' => 620,  'status' => 'disponible', 'dim' => 7],
            ['titre' => 'L\'instant suspendu', 'annee' => 2022, 'photo_principale' => null,'orientation' => 'carre',    'cat' => $photo_id,     'support' => 5, 'artiste' => 2, 'reduction' => 0.10, 'visible' => true,  'prix' => 390,  'status' => 'disponible', 'dim' => 4],
            ['titre' => 'Lumière rasante',      'annee' => 2023,'photo_principale' => null, 'orientation' => 'paysage',  'cat' => $photo_id,     'support' => 5, 'artiste' => 2, 'reduction' => null, 'visible' => true,  'prix' => 750,  'status' => 'vendu',      'dim' => 11],
            // Claire Leroy — Peinture
            ['titre' => 'Calanque bleue',       'annee' => 2024, 'photo_principale' => 'oeuvres/calanque_image.img', 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 3, 'reduction' => null, 'visible' => true,  'prix' => 1100, 'status' => 'disponible', 'dim' => 10],
            ['titre' => 'Marché provençal',     'annee' => 2023, 'photo_principale' => 'oeuvres/marche_image.img', 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 3, 'reduction' => null, 'visible' => true,  'prix' => 890,  'status' => 'disponible', 'dim' => 9],
            ['titre' => 'Soleil couchant',      'annee' => 2022, 'photo_principale' => 'oeuvres/soleil_couchant.img', 'orientation' => 'carre',    'cat' => $peinture_id,  'support' => 2, 'artiste' => 3, 'reduction' => 0.25, 'visible' => true,  'prix' => 720,  'status' => 'disponible', 'dim' => 5],
            ['titre' => 'Mistral',              'annee' => 2024, 'photo_principale' => 'oeuvres/Mistral_image.img', 'orientation' => 'portrait', 'cat' => $peinture_id,  'support' => 1, 'artiste' => 3, 'reduction' => null, 'visible' => true,  'prix' => 980,  'status' => 'disponible', 'dim' => 8],
            ['titre' => 'Nuit étoilée du sud',  'annee' => 2021, 'photo_principale' => null, 'orientation' => 'paysage',  'cat' => $peinture_id,  'support' => 1, 'artiste' => 3, 'reduction' => null, 'visible' => true,  'prix' => 1350, 'status' => 'vendu',      'dim' => 11],
        ];

        $oeuvre_ids = [];

        foreach ($oeuvres as $o) {
            $created = Carbon::now()->subDays(rand(1, 90));
            if ($o['photo_principale']) {
                $oeuvre_id = DB::table('oeuvres')->insertGetId([
                    'titre'             => $o['titre'],
                    'annee_de_creation' => $o['annee'],
                    'taux_reduction'    => $o['reduction'],
                    'photo_principale'  => $o['photo_principale'],
                    'orientation'       => $o['orientation'],
                    'description'       => 'Une œuvre remarquable qui témoigne du talent et de la sensibilité de l\'artiste.',
                    'categorie_id'      => $o['cat'],
                    'support_id'        => $o['support'],
                    'artiste_id'        => $artiste_ids[$o['artiste']],
                    'visible'           => $o['visible'],
                    'created_at'        => $created,
                    'updated_at'        => $created,
                ]);
            }
            else{
                $oeuvre_id = DB::table('oeuvres')->insertGetId([
                    'titre'             => $o['titre'],
                    'annee_de_creation' => $o['annee'],
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
            }
            


            $oeuvre_ids[] = $oeuvre_id;

            DB::table('tirages')->insert([
                'oeuvre_id'         => $oeuvre_id,
                'numero'            => 1,
                'status'            => $o['status'],
                'prix'              => $o['prix'],
                'encadrement'       => rand(0, 1),
                'pret_a_accrocher'  => rand(0, 1),
                'dimensions_id'     => $dim_ids[$o['dim']],
                'commande_id'      => null,
                'avec_cadre'        => rand(0, 1),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // Associations artiste/catégorie
        $artiste_cats = [[0, 0], [1, 1], [2, 2], [3, 0]];
        $cat_ids = DB::table('categories')->whereNull('id_categorie_parente')->orderBy('id')->pluck('id')->toArray();

        foreach ($artiste_cats as [$art, $cat]) {
            DB::table('artiste_categorie')->insert([
                'artiste_id'  => $artiste_ids[$art],
                'categorie_id' => $cat_ids[$cat],
            ]);
        }

        // Associations thèmes/couleurs
        $themes  = DB::table('themes')->pluck('id', 'nom_theme');
        $couleurs = DB::table('couleurs')->pluck('id', 'nom_couleur');

        $associations = [
            0  => ['themes' => ['Abstrait'],               'couleurs' => ['Rouge', 'Orange', 'Jaune']],
            1  => ['themes' => ['Mer', 'Abstrait'],        'couleurs' => ['Bleu', 'Blanc']],
            2  => ['themes' => ['Abstrait'],               'couleurs' => ['Rouge', 'Noir']],
            3  => ['themes' => ['Abstrait'],               'couleurs' => ['Bleu', 'Blanc']],
            4  => ['themes' => ['Paysage'],                'couleurs' => ['Jaune', 'Orange']],
            5  => ['themes' => ['Portrait'],               'couleurs' => ['Marron', 'Noir']],
            6  => ['themes' => ['Portrait', 'Femme'],      'couleurs' => ['Marron', 'Noir']],
            7  => ['themes' => ['Abstrait'],               'couleurs' => ['Rouge', 'Noir', 'Blanc']],
            8  => ['themes' => ['Portrait'],               'couleurs' => ['Marron', 'Noir']],
            9  => ['themes' => ['Paysage', 'Nature morte'], 'couleurs' => ['Blanc', 'Bleu']],
            10 => ['themes' => ['Urbain'],                 'couleurs' => ['Noir', 'Blanc']],
            11 => ['themes' => ['Portrait', 'Femme'],      'couleurs' => ['Marron', 'Rose']],
            12 => ['themes' => ['Paysage'],                'couleurs' => ['Jaune', 'Orange']],
            13 => ['themes' => ['Mer', 'Paysage'],         'couleurs' => ['Bleu', 'Vert']],
            14 => ['themes' => ['Urbain', 'Paysage'],      'couleurs' => ['Orange', 'Jaune', 'Rouge']],
            15 => ['themes' => ['Paysage'],                'couleurs' => ['Orange', 'Rouge', 'Jaune']],
            16 => ['themes' => ['Paysage', 'Abstrait'],    'couleurs' => ['Bleu', 'Blanc']],
            17 => ['themes' => ['Paysage'],                'couleurs' => ['Bleu', 'Violet', 'Noir']],
        ];

        foreach ($associations as $index => $assoc) {
            $oeuvre_id = $oeuvre_ids[$index];

            foreach ($assoc['themes'] as $nom) {
                DB::table('oeuvre_theme')->insert(['oeuvre_id' => $oeuvre_id, 'theme_id' => $themes[$nom]]);
            }

            foreach ($assoc['couleurs'] as $nom) {
                DB::table('oeuvre_couleur')->insert(['oeuvre_id' => $oeuvre_id, 'couleur_id' => $couleurs[$nom]]);
            }
        }

        $this->command->info('✅ Œuvres, tirages et associations créés.');
    }
}
