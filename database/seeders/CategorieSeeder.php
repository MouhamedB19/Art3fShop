<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        // Catégories parentes
        $peinture_id = DB::table('categories')->insertGetId([
            'nom_categorie'        => 'Peinture',
            'nom_technique'        => null,
            'description_courte'   => 'Œuvres réalisées à l\'aide de pigments appliqués sur une surface.',
            'description_longue'   => 'La peinture est une forme d\'art visuel qui utilise des pigments pour créer des images sur divers supports.',
            'id_categorie_parente' => null,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        $sculpture_id = DB::table('categories')->insertGetId([
            'nom_categorie'        => 'Sculpture',
            'nom_technique'        => null,
            'description_courte'   => 'Œuvres en trois dimensions créées par modelage, taille ou assemblage.',
            'description_longue'   => 'La sculpture est une forme d\'art tridimensionnelle qui consiste à créer des œuvres en modelant, taillant ou assemblant des matériaux.',
            'id_categorie_parente' => null,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        $photo_id = DB::table('categories')->insertGetId([
            'nom_categorie'        => 'Photographie',
            'nom_technique'        => null,
            'description_courte'   => 'Œuvres créées à l\'aide d\'un appareil photo capturant la lumière.',
            'description_longue'   => 'La photographie est une forme d\'art qui utilise la lumière pour capturer des images à l\'aide d\'un appareil photo.',
            'id_categorie_parente' => null,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        DB::table('categories')->insert([
            [
                'nom_categorie'        => 'Édition',
                'nom_technique'        => null,
                'description_courte'   => 'Œuvres produites en série limitée à partir d\'une matrice originale.',
                'description_longue'   => 'L\'édition est une forme d\'art qui consiste à produire des œuvres en série limitée.',
                'id_categorie_parente' => null,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'nom_categorie'        => 'Dessin',
                'nom_technique'        => null,
                'description_courte'   => 'Œuvres réalisées à l\'aide de crayons, fusains ou encres.',
                'description_longue'   => 'Le dessin est une forme d\'art qui utilise des outils tels que des crayons, des fusains ou des encres.',
                'id_categorie_parente' => null,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ]);

        // Sous-catégories
        DB::table('categories')->insert([
            ['nom_categorie' => 'Peinture à l\'huile', 'nom_technique' => 'Huile sur toile',      'id_categorie_parente' => $peinture_id,  'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Peinture acrylique',  'nom_technique' => 'Acrylique sur toile',  'id_categorie_parente' => $peinture_id,  'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Aquarelle',            'nom_technique' => 'Aquarelle sur papier', 'id_categorie_parente' => $peinture_id,  'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Sculpture bronze',     'nom_technique' => 'Bronze',               'id_categorie_parente' => $sculpture_id, 'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Sculpture résine',     'nom_technique' => 'Résine',               'id_categorie_parente' => $sculpture_id, 'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Photo argentique',     'nom_technique' => 'Argentique',           'id_categorie_parente' => $photo_id,     'created_at' => now(), 'updated_at' => now()],
            ['nom_categorie' => 'Photo numérique',      'nom_technique' => 'Numérique',            'id_categorie_parente' => $photo_id,     'created_at' => now(), 'updated_at' => now()],
        ]);

        // Supports
        $supports = [
            'Toile sur châssis', 'Toile libre', 'Papier', 'Bois',
            'Aluminium', 'Plexiglas', 'Marbre', 'Bronze', 'Résine',
        ];

        foreach ($supports as $support) {
            DB::table('supports')->insert([
                'nom_support' => $support,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('✅ Catégories et supports créés.');
    }
}