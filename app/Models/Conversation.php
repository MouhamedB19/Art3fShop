<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'commande_id',
        'client_id',
        'artiste_id',
    ];

    public function commande(){
        return $this->hasMany(Commande::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function artiste(){
        return $this->belongsTo(Artiste::class);
    }
}
