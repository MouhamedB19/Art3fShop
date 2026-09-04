<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    protected $fillable = [
        'status',
        'clients_id',
        'localisation_id',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'clients_id');
    }
    public function localisation()
    {
        return $this->belongsTo(Localisation::class, 'localisation_id');
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_livraison', 'livraison_id', 'commande_id');
    }
}
