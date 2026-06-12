<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oeuvre extends Model
{
    protected $fillable = [
        'titre',
        'annee_de_creation',
        'photo_principale',
        'orientation',
        'description',
        'visible',
        'categorie_id',
        'support_id',
        'artiste_id',
    ];
    
    public function artiste(){
        return $this->belongsTo(Artiste::class);
    }
    
    public function clients(){
        return $this->belongsToMany(Client::class,'oeuvre_client','oeuvre_id','client_id')->withTimestamps();
    }
    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    public function support(){
        return $this->belongsTo(Support::class);
    }

    public function themes(){
        return $this->belongsToMany(Theme::class, 'oeuvre_theme', 'oeuvre_id', 'theme_id');
    }
    
    public function couleurs(){
        return $this->belongsToMany(Couleur::class, 'oeuvre_couleur', 'oeuvre_id', 'couleur_id');
    }

    public function tirages(){
        return $this->hasMany(Tirage::class);
    }
    public function campagnes(){
        return $this->hasMany(Campagne_pub::class, 'oeuvre_id');
    }

    public function selections(){
        return $this->belongsToMany(Selection::class, 'oeuvre_selection', 'oeuvre_id', 'selection_id');
    }

}
