<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OeuvreResource extends JsonResource
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
            'titre' => $this->titre,
            'description' => $this->description,
            'date_creation' => $this->date_creation,
            'taux_reduction' => $this->taux_reduction,
            'photo_principale' => $this->photo_principale,
            'orientation'   => $this->orientation,
            'visible'   => $this->visible,
            'categorie_id' => $this->categorie_id,
            'support_id'    => $this->support_id,
            'artiste' => [
                'id' => $this->artiste->id,
                'nom_d_artiste' => $this->artiste->nom_d_artiste,
                'user' => [
                    'id' => $this->artiste->user->id,
                    'nom' => $this->artiste->user->nom,
                    'prenom' => $this->artiste->user->prenom,
                ], 
            ],  
            'created_at'    => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
