<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    public function oeuvres()
    {
        return $this->belongsToMany(Oeuvre::class, 'oeuvre_selection');
    }
}
