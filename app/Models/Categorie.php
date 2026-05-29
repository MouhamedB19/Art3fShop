<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'nom_categorie',
        'nom_technique',
        'id_categorie_parente',
    ];

    public function oeuvres(){
        return $this->hasMany(Oeuvre::class);
    }

    public function parent(){
        return $this->hasOne(Categorie::class);
    }
    public function enfants(){
        return $this->belongsTo(Categorie::class);
    }

    public function artistes(){
        return $this->belongsToMany(Artiste::class, 'artiste_categorie', 'categorie_id','artiste_id');
    }

    
}
