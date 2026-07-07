<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
class ArtisteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            'bio' => $this->bio,
            'nom_d_artiste' => $this->nom_d_artiste,
            'Est_Artiste_Art3f' => $this->Est_Artiste_Art3f ? "Affilié à Art3f": "Non affilié à Art3f",
            'a_la_une' => $this->a_la_une ? "Artiste à la une": "Artiste standard",
            'localisation' => $this->localisation,
        ];
    }
}
