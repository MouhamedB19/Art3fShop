<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tirage extends Model
{
    //
    protected $fillable = [
        'oeuvre_id',
        'numero',
        'status',
        'prix',
        'encadrement',
        'pret_a_accrocher',
        'dimensions_id',
        'commande_id',
        'avec_cadre',
    ];

    public function dimension(){
        return $this->belongsTo(Dimension::class, 'dimensions_id');
    }

    public function commandes(){
        return $this->hasMany(Commande::class, 'commande_id');
    }

    public function clients(){
        return $this->belongsToMany(Client::class, 'commande_client', 'tirage_id', 'client_id');
    }

    public function clientTirages(){
        return $this->belongsToMany(Client::class, 'client_tirage', 'tirage_id', 'client_id')->withPivot('quantite');
    }

    public function oeuvre(){
        return $this->belongsTo(Oeuvre::class, 'oeuvre_id');
    }

}

