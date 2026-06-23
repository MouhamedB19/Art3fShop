<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable =[
        'code',
        'type',
        'valeur',
        'montant_min',
        'date_debut',
        'date_fin',
        'utiisation_max',
        'nombre_utilisations',
    ];
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'coupon_commande','commande_id','coupon_id');
    }
}
