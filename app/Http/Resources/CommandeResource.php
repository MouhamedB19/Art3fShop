<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TirageResource;
use App\Calculs\CalculeReduction;

class CommandeResource extends JsonResource
{
    use CalculeReduction;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $prix_total = 0;
        foreach ($this->tirages as $tirage) {
            $prix = $tirage->oeuvre->taux_reduction ? $tirage->oeuvre->prix * (1 - $tirage->oeuvre->taux_reduction / 100) : $tirage->oeuvre->prix;
            $prix_total += $prix;
        }
        return [
            'id' => $this->id,
            'date_commande' => $this->date_commande,
            'est_cadeau' => $this->est_cadeau,
            'message_cadeau' => $this->message_cadeau,
            'prix_total' => $prix_total,
            'prix_total_apres_remise' => CalculeReduction::calculerReduction($prix_total, $this->coupons),
            'tirages' => TirageResource::collection($this->tirages),
            'livraisons' => LivraisonResource::collection($this->livraisons),
            'coupons' => CouponResource::collection($this->coupons),
            
        ];
    }
}
