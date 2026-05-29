<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
}
