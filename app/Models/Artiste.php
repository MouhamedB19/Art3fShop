<?php

namespace App\Models;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Artiste extends Model
{
    protected $fillable = [
        'nom_d_artiste',
        'bio',
        'photo',
        'Est_Artiste_Art3f',
        'iban',
        'CV',
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
        return $this->belongsToMany(Client::class,'artiste_client','artiste_id','client_id');
    }

    public function campagnes(){
        return $this->hasMany(Campagne_pub::class, 'artiste_id');
    }

    public function conversations(){
        return $this->hasMany(Conversation::class,'artiste_id');
    }

    use Searchable;

    public function toSearchableArray()
    {
        return([
            'id' => $this->id,
            'nom' => $this->nom_d_artiste ? $this->nom_d_artiste : $this->user->nom . ' ' . $this->user->prenom,
            'bio' => $this->bio,
        ]);
    }
}
