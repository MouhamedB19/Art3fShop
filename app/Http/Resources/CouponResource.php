<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            "type" => $this->type,
            "valeur" => $this->valeur,
            "montant_minimum" => $this->montant_min,
            "date_de_debut" => $this->date_debut,
            "date_d_expiration" => $this->date_fin,
            "utilisations_maximales" => $this->utilisations_max,
            "utilisations_actuelles" => $this->nombre_utilisations,
        ];
    }
}
