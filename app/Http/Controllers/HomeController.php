<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campagne_pub;
use App\Models\Artiste;

class HomeController extends Controller
{
    public function index()
    {
        $campagnesHero = Campagne_pub::with(['artiste', 'oeuvre'])
            ->where('emplacement_id', 'home_une')
            ->where('statut', 'active')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->orderBy('date_debut')
            ->get();
        $artisteUne = Artiste::with(['oeuvres' => function ($query) {
            $query->latest()->limit(4);
        }])
            ->where('a_la_une', true)
            ->inRandomOrder() // si plusieurs artistes sont cochés "à la une", on en tire un au hasard
            ->first();
        return view('home.index', compact('campagnesHero','artisteUne'));
    }
}
