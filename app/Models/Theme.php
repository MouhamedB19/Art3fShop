<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'nom_theme',
    ];

    public function oeuvres()
    {
        return $this->belongsToMany(Oeuvre::class, 'oeuvre_theme', 'theme_id', 'oeuvre_id');
    }
}
