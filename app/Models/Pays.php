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
}
