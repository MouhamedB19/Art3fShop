<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TirageResource;
use App\Models\Tirage;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;

        if (!$client) {
            return response()->json(['message' => 'Client non trouvé', 'code' => 404]);
        }
        $tiragesPaniers = $client->tirages();
        return TirageResource::collection($tiragesPaniers->get());
    }

    public function addToPanier($tirageId)
    {
        $client = Auth::user()->client;

        if (!$client)
            return response()->json(['message' => 'Client non trouvé', 'code' => 404]);

        $tirage = Tirage::find($tirageId);


        if($client->tirages()->count() >=5)
            return response()->json(['message' => 'Vous ne pouvez pas ajouter plus de 5 tirages à votre panier', 'code' => 405]);
        if (!$tirage)
            return response()->json(['message' => 'Tirage non trouvé', 'code' => 400]);
        else if ($tirage->status !== 'disponible')
            return response()->json(['message' => 'Tirage non disponible', 'code' => 400]);

        if ($client->tirages()->where('tirage_id', $tirageId)->exists())
            $client->tirages()->updateExistingPivot($tirage->id, [
                'quantite' => DB::raw('quantite + ' . ($request->quantite ?? 1))
            ]);
        else 
        {
            $client->tirages()->attach($tirage->id, ['quantite' => 1]);
            return response()->json(['message' => 'Tirage ajouté au panier', 'code' => 200]);
        }
        
    }

    public function removeFromPanier($tirageId)
    {
        $client = Auth::user()->client;

        if (!$client)
            return response()->json(['message' => 'Client non trouvé', 'code' => 404]);

        $tirage = Tirage::find($tirageId);

        if (!$tirage)
            return response()->json(['message' => 'Tirage non trouvé', 'code' => 400]);

        if ($client->tirages()->where('tirage_id', $tirageId)->exists()) {
            $client->tirages()->detach($tirage->id);
            return response()->json(['message' => 'Tirage retiré du panier', 'code' => 200]);
        } else {
            return response()->json(['message' => 'Tirage non présent dans le panier', 'code' => 400]);
        }
    }
    
}
