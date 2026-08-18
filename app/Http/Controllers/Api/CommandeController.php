<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Localisation;
use App\Models\Ville;
use App\Models\Livraison;
use App\Http\Resources\CommandeResource;

class CommandeController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $tirages = $user->client->tirages;
        if ($tirages->isEmpty()) {
            return response()->json([
                'message' => 'Le panier est vide. Veuillez ajouter des tirages avant de passer une commande.',
                'code' => 400
            ]);
        }

        $dataCommande = $request->validate([
            'est_cadeau' => 'sometimes | boolean',
            'message_cadeau' => 'sometimes | string'
        ]);

        $dataLocalisation = $request->validate([
            'code_postal' => 'required|string',
            'adresse' => 'required | string',
        ]);

        $dataVille = $request->validate([
            'nom_ville' => 'required|string',
            'pays' => 'required | exists:pays, id'
        ]);

        $ville = Ville::findOrCreate([
            'nom_ville' => $dataVille['nom_ville'],
            'pays' => $dataVille['pays']
        ]);

        $localisation = Localisation::findOrCreate([
            'code_postal' => $dataLocalisation['code_postal'],
            'adresse' => $dataLocalisation['adresse'],
            'ville_id' => $ville->id
        ]);


        $commande = Commande::create([
            'date_commande' => now(),
            'est_cadeau' => $dataCommande['est_cadeau'] ?? false,
            'message_cadeau' => $dataCommande['message_cadeau'] ?? null,
            'user_id' => $user->id,
        ]);

        $livraison = Livraison::create([
            'status' => 'en cours',
            'localisation_id' => $localisation->id,
            'clients_id' => $user->client->id,
        ]);

        $commande->livraisons()->attach($livraison->id);
        $commande->tirages()->saveMany($tirages);
        $user->client->tirages()->detach($tirages->pluck('id'));

        return (new CommandeResource($commande))->additional([
            'message' => 'Commande créée avec succès.',
            'code' => 201
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        $commandes = Commande::where('user_id',$user->id)->get();
        return CommandeResource::collection($commandes);
    }
}
