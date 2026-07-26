<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TirageResource;
use App\Http\Resources\CouleurResource;
use App\Http\Resources\ThemeResource;
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
            'annee_creation' => $this->annee_de_creation,
            'taux_reduction' => $this->taux_reduction,
            'photo_principale' => $this->photo_principale,
            'orientation'   => $this->orientation,
            'categorie' => $this->categorie,
            'support'    => $this->support,
            'artiste' => [
                'id' => $this->artiste->id,
                'nom_d_artiste' => $this->artiste->nom_d_artiste,
                'user' => [
                    'id' => $this->artiste->user->id,
                    'nom' => $this->artiste->user->nom,
                    'prenom' => $this->artiste->user->prenom,
                ],
            ],
            'tirages' => TirageResource::collection($this->tirages),

            'themes' => new ThemeResource($this->themes),

            'couleurs' => new CouleurResource($this->couleurs),
            'created_at'    => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
