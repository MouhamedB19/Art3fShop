<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $fillable = [
        'nom_pays',
        'devise',
    ];

    public function villes(){
        return $this->hasMany(Ville::class);
    }

    public function estDansUE(string $nomPays): bool
    {
        $paysUE = [
            'France', 'Allemagne', 'Espagne', 'Italie', 'Belgique', 'Pays-Bas',
            'Portugal', 'Luxembourg', 'Autriche', 'Irlande', 'Pologne',
            
        ];

        return in_array($nomPays, $paysUE);
    }
}
