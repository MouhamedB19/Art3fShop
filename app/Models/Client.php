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

    public function conversations(){
        return $this->hasMany(Conversation::class,'client_id');
    }
    
    public function oeuvres(){
        return $this->belongsToMany(Oeuvre::class, 'oeuvre_client', 'client_id', 'oeuvre_id');
    }
    
    public function artistes(){
        return $this->belongsToMany(Artiste::class, 'artiste_client', 'artiste_id', 'client_id');
    }

    public function tiragesFavoris(){
        return $this->belongsToMany(Tirage::class, 'tirage_client','client_id', 'tirage_favoris_id');
    }
}
