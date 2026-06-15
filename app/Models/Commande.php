<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'date_commande',
        'user_id',
    ];

    protected $casts = [
        'date_commande' => 'datetime',
    ];

    public function client(){
        return $this->belongsTo(Client::class,'user_id');
    }

    public function tirages(){
        return $this->hasMany(Tirage::class);
    }

    public function livraisons(){
        return $this->belongsToMany(Livraison::class,'commande_livraison','commande_id','livraison_id');
    }

    public function conversation(){
        return $this->hasOne(Conversation::class);
    }

    
}
