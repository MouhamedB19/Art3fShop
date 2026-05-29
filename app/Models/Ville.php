<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $fillable = [
        'nom',
        'pays_id',
    ];

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

    public function localisations(){
        return $this->hasMany(Localisation::class);
    }
}
