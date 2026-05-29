<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'nom_support',
    ];

    public function oeuvres(){
        return $this->hasMany(Oeuvre::class);
    }
}
