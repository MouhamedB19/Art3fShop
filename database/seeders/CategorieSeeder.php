<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;
class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            // Catégories racines
            ['nom_categorie' => 'Peinture',      'nom_technique' => null, 'id_categorie_parente' => null],
            ['nom_categorie' => 'Sculpture',     'nom_technique' => null, 'id_categorie_parente' => null],
            ['nom_categorie' => 'Photographie',  'nom_technique' => null, 'id_categorie_parente' => null],
            ['nom_categorie' => 'Dessin',        'nom_technique' => null, 'id_categorie_parente' => null],
            ['nom_categorie' => 'Edition',       'nom_technique' => null, 'id_categorie_parente' => null],
    
            // Sous-catégories Peinture (id=1)
            ['nom_categorie' => 'Acrylique',        'nom_technique' => 'Peinture acrylique',       'id_categorie_parente' => 1],
            ['nom_categorie' => 'Huile',             'nom_technique' => 'Peinture à l\'huile',      'id_categorie_parente' => 1],
            ['nom_categorie' => 'Aquarelle',         'nom_technique' => 'Aquarelle',                'id_categorie_parente' => 1],
            ['nom_categorie' => 'Technique mixte',   'nom_technique' => 'Technique mixte',          'id_categorie_parente' => 1],
    
            // Sous-catégories Sculpture (id=2)
            ['nom_categorie' => 'Bronze',        'nom_technique' => 'Sculpture bronze',    'id_categorie_parente' => 2],
            ['nom_categorie' => 'Marbre',        'nom_technique' => 'Sculpture marbre',    'id_categorie_parente' => 2],
            ['nom_categorie' => 'Résine',        'nom_technique' => 'Sculpture résine',    'id_categorie_parente' => 2],
            ['nom_categorie' => 'Argile',        'nom_technique' => 'Sculpture argile',    'id_categorie_parente' => 2],
            ['nom_categorie' => 'Bois',          'nom_technique' => 'Sculpture bois',      'id_categorie_parente' => 2],
    
            // Sous-catégories Photographie (id=3)
            ['nom_categorie' => 'Numérique',     'nom_technique' => 'Photographie numérique',   'id_categorie_parente' => 3],
            ['nom_categorie' => 'Argentique',    'nom_technique' => 'Photographie argentique',  'id_categorie_parente' => 3],
    
            // Sous-catégories Dessin (id=4)
            ['nom_categorie' => 'Crayon',        'nom_technique' => 'Dessin au crayon',    'id_categorie_parente' => 4],
            ['nom_categorie' => 'Encre',         'nom_technique' => 'Dessin à l\'encre',   'id_categorie_parente' => 4],
            ['nom_categorie' => 'Pastel',        'nom_technique' => 'Dessin au pastel',    'id_categorie_parente' => 4],
    
            // Sous-catégories Edition (id=5)
            ['nom_categorie' => 'Estampe',       'nom_technique' => 'Estampe',             'id_categorie_parente' => 5],
            ['nom_categorie' => 'Sérigraphie',   'nom_technique' => 'Sérigraphie',         'id_categorie_parente' => 5],
            ['nom_categorie' => 'Lithographie',  'nom_technique' => 'Lithographie',        'id_categorie_parente' => 5],
        ];
    
        foreach($categories as $cat) {
            Categorie::create($cat);
        }
    }
}
