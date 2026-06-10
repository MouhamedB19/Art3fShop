<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    protected $fillable = [
        'code_postal',
        'adresse',
        'ville_id',
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function artistes()
    {
        return $this->hasMany(Artiste::class);
    }
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function livraisons()
    {
        return $this->hasMany(Livraison::class);
    }

    public function salon(){
        return $this->hasMany(Salon::class,'localisation_id');
    }
    
}
