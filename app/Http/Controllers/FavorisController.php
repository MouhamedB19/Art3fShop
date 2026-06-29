<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Tirage;

class FavorisController extends Controller
{
    public function favorisOeuvres()
    {
        $oeuvres = Auth::user()->oeuvresFavoris()->get();
        return view('compte.favoris.oeuvres', compact('oeuvres'));
    }

    public function favorisArtistes()
    {
        $artistes = Auth::user()->artistesFavoris()->get();
        return view('compte.favoris.artistes', compact('artistes'));
    }

    public function handleOeuvre($tirage)
    {
        $client = Auth::user()->client;
        
        if($client->tiragesFavoris()->where('tirage_favoris_id',$tirage)->exists())
        {
            $client->tiragesFavoris()->detach($tirage);
            return back()->with('success','Oeuvre retirée des favoris');
           
        }

        if($client->tiragesFavoris()->count() >= 5)
        {
            $client->tiragesFavoris()->detach($tirage);
            return back()->with('error','Vous n\'avez le droit qu\'à 5 oeuvres favorites maximum');
        }
            
        else{
            $client->tiragesFavoris()->attach($tirage);
            return back()->with('success','Oeuvre ajoutée aux favoris');
        }
        
    }
}
