<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'localisations_id',
        'user_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function localisations(){
        return $this->belongsTo(Localisation::class);
    }

    public function tirages(){
        return $this->belongsToMany(Tirage::class, 'client_tirage', 'client_id', 'tirage_id')->withPivot('quantite');
    }

    public function oeuvresFavoris(){
        return $this->belongsToMany(Oeuvre::class, 'client_oeuvre_favoris', 'client_id', 'oeuvre_id')->withTimestamps();
    }
}
