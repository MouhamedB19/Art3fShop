<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artiste extends Model
{
    protected $fillable = [
        'bio',
        'photo',
        'Est_Artiste_Art3f',
        'iban',
        'user_id',
        'localisations_id',
    ];

    protected $casts = [
        'iban' => 'encrypted',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function localisation(){
        return $this->belongsTo(Localisation::class,'localisations_id');
    }

    public function oeuvres(){
        return $this->hasMany(Oeuvre::class);
    }

    public function categories(){
        return $this->belongsToMany(Categorie::class);
    }

    public function clients(){
        return $this->belongsToMany(Client::class);
    }

    public function campagnes(){
        return $this->hasMany(Campagne_pub::class, 'artiste_id');
    }

}
