<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    protected $fillable = [
        'hauteur',
        'largeur',
    ];

    public function tirage()
    {
        return $this->hasMany(Tirage::class);
    }
}
