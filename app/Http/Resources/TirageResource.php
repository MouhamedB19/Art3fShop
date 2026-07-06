<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TirageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'status' => $this->status,
            'oeuvre' => new OeuvreResource($this->oeuvre),
            'largeur' => $this->dimension->largeur,
            'hauteur' => $this->dimension->hauteur,
            'prix' => $this->prix,
            'encadrement' => $this->encadrement,
            'pret_a_accrocher' => $this->pret_a_accrocher,
            'avec_cadre' => $this->avec_cadre,
            'commande_id' => $this->commande_id,
        ];
    }
}
