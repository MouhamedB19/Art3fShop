<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couleur extends Model
{
    protected $fillable = [
        'nom_couleur',
    ];

    public function oeuvres(){
        return $this->belongsToMany(Oeuvre::class, 'couleur_oeuvre', 'couleur_id', 'oeuvre_id');
    }
}
