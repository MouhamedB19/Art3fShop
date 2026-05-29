<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campagne_pub extends Model
{
    protected $fillable = [
        'artiste_id',
        'oeuvre_id',
        'type',
        'statut',
        'emplacement_id',
        'visuel',
        'lien_cible',
        'date_debut',
        'date_fin',
        'montant_paye',
        'paiement_statut',
        'stripe_paiement_id',
        'impressions',
        'clics',
    ];

    public function emplacement()
    {
        return $this->belongsTo(Emplacement_pub::class, 'emplacement_id', 'code');
    }
    public function artiste()
    {
        return $this->belongsTo(Artiste::class, 'artiste_id');
    }
    public function oeuvre()
    {
        return $this->belongsTo(Oeuvre::class, 'oeuvre_id');
    }
}
