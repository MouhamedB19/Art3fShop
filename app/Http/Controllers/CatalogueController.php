<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Oeuvre;
use App\Models\Categorie;
use App\Models\Tirage;
use App\Models\Couleur;
use App\Models\Support;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class CatalogueController extends Controller
{
    public function index()
    {
        return view('catalogue.index');
    }
    public function categorie($categorie)
    {
        $c = Categorie::where('nom_categorie', $categorie)->firstOrFail();
        $oeuvres = Oeuvre::all();
        $oeuvresCategorie = $oeuvres->where('categorie_id',$c->id)
                                     ->merge($oeuvres->filter(fn ($oeuvre) => $oeuvre->categorie?->id_categorie_parente == $c->id));
        $tiragesCorrespondants = Tirage::whereIn('oeuvre_id', $oeuvresCategorie->pluck('id'))->get();
        return view('catalogue.categorie', compact('oeuvresCategorie', 'categorie','tiragesCorrespondants'));
    }

    public function theme($theme)
    {
        $t = Theme::where('nom_theme', $theme)->firstOrFail();
    
        $oeuvresCorrespondantes = Oeuvre::whereHas('themes', function ($query) use ($t) {
            $query->where('themes.id', $t->id);
        })->with('themes')->get();
    
        $tiragesCorrespondants = Tirage::whereIn(
            'oeuvre_id',
            $oeuvresCorrespondantes->pluck('id')
        )->get();
    
        return view('catalogue.theme', compact('oeuvresCorrespondantes', 'theme', 'tiragesCorrespondants'));
    }
  
}
