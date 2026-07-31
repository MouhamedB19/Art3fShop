<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nom_categorie' => $this->nom_categorie,
            'nom_technique' => $this->nom_technique,
            'description_courte' => $this->description_courte,
            'description_longue' => $this->description_longue,
        ];
    }
}
