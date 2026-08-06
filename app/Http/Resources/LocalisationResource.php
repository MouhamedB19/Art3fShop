<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\VilleResource;
class LocalisationResource extends JsonResource
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
            'code_postal' => $this->code_postal,
            'adresse' => $this->adresse,
            'ville' => new VilleResource($this->ville)
        ];
    }
}
