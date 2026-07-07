<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TirageResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ArtisteResource;

class FavorisController extends Controller
{
    public function indexTirages()
    {
        $client = Auth::user()->client;
        $favoris = $client->tiragesFavoris()->get();
        return TirageResource::collection($favoris);
    }

    public function addTirageFavoris($tirageId)
    {
        $client = Auth::user()->client;
        if($client->tiragesFavoris()->count() >= 5)
            return response()->json(['message' => 'Vous ne pouvez pas avoir plus de 5 oeuvres favorites.', 'code' => 405]);

        if($client->tiragesFavoris()->where('tirage_favoris_id', $tirageId)->exists())
            $client->tiragesFavoris()->detach($tirageId);
        else
        {
            $client->tiragesFavoris()->attach($tirageId);
            return response()->json(['message' => 'Tirage ajouté aux favoris', 'code' => 200]);
        }
    }

    public function indexArtistes()
    {
        $client = Auth::user()->client;
        $artistes = $client->artistes()->get();
        return ArtisteResource::collection($artistes);
    }

    public function addArtistes($artisteId)
    {
        $client = Auth::user()->client;
        if($client->artistes()->count() >= 5)
            return response()->json(['message' => 'Vous ne pouvez pas avoir plus de 5 artistes favoris', 'code' => 400]);

        if($client->artistes()->where('artiste_id', $artisteId)->exists()){
            $client->artistes()->detach($artisteId);
            return response()->json(['message' => 'Artiste retiré des favoris', 'code' => 200]);
        }
        else
        {
            $client->artistes()->attach($artisteId);
            return response()->json(['message' => 'Artiste ajouté aux favoris', 'code' => 200]);
        }            
    }
}
