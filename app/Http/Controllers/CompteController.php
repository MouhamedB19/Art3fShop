<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompteController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();

        if ($user->estArtiste()) {
            return view('artiste.index', [  // → resources/views/artiste/index.blade.php
                'oeuvres' => $user->artiste->oeuvres()->latest()->take(5)->get(),
                //'ventes'  => $user->artiste->ventes()->latest()->take(5)->get(),
            ]);
        }
        else{
            return view('compte.index', [       // → resources/views/compte/index.blade.php
                'artistes' => $user->client->artistes()->latest()->take(5)->get(),
                'oeuvres'   => $user->client->oeuvres()->take(5)->get(),
            ]);
        }
    }

    public function indexCommandes()
    {
        $user = Auth::user();
        if($user)
        {
            $commandes = $user->commandes()->get();
            return view('compte.commandes',compact('commandes'));
        }
    }
}
