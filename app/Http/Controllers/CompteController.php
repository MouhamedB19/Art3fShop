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

        if ($user->isArtiste()) {
            return view('artiste.index', [  // → resources/views/artiste/index.blade.php
                'oeuvres' => $user->artiste->oeuvres()->latest()->take(5)->get(),
                'ventes'  => $user->artiste->ventes()->latest()->take(5)->get(),
                'favoris' => $user->favorisOeuvres()->take(5)->get(),
            ]);
        }

        return view('compte.index', [       // → resources/views/compte/index.blade.php
            'commandes' => $user->commandes()->latest()->take(5)->get(),
            'favoris'   => $user->favorisOeuvres()->take(5)->get(),
        ]);
    }
}
