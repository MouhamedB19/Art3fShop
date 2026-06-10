<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model{
    protected $fillable = [
        'date_salon',
        'localisation_id',
    ];

    public function localisation(){
        return $this->belongsTo(Localisation::class,'localisation_id');
    }

    public function artistes(){
        return $this->belongsToMany(Artiste::class);
    }

    public function tirages(){
        return $this->belongsToMany(Tirage::class);
    }
};