<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TirageResource;

class CommandeResource extends JsonResource
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
            'date_commande' => $this->date_commande,
            'est_cadeau' => $this->est_cadeau,
            'message_cadeau' => $this->message_cadeau,
            'tirages' => TirageResource::collection($this->tirages),
        ];
    }
}
