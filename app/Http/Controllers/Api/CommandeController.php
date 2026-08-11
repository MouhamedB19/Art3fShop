<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Http\Resources\CommandeResource;

class CommandeController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $tirages = $user->client->tirages;
        if($tirages->isEmpty()){
            return response()->json([
                'message' => 'Le panier est vide. Veuillez ajouter des tirages avant de passer une commande.',
                'code' => 400
            ]);
        }

        $dataCommande = $request->validate([
            'est_cadeau' => 'sometimes | boolean',
            'message_cadeau' => 'sometimes | string'
        ]);

        $commande = Commande::create([
            'date_commande' => now(),
            'est_cadeau' => $dataCommande['est_cadeau'] ?? false,
            'message_cadeau' => $dataCommande['message_cadeau'] ?? null,
            'user_id' => $user->id,
        ]);

        $commande->tirages()->saveMany($tirages);
        $user->client->tirages()->detach($tirages->pluck('id'));
        return (new CommandeResource($commande))->additional([
            'message' => 'Commande créée avec succès.',
            'code' => 201
        ]);

    }
}
