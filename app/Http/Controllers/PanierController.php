<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tirage;
use App\Models\Oeuvre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index()
    {
        // Logique pour afficher le panier
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir votre panier.');
        }
        $client = $user->client->with("tirages.oeuvre")->first();
        $total = 0;
        if($client){
            $total = $client->tirages->sum('prix');
        }
        return view('panier.index', [
            'client' => $client,
            'tirage' => $client ? $client->tirages : collect(),
            'total' => $total
        ]);
    }
}
