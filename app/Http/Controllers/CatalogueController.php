<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Oeuvre;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Support;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
class CatalogueController extends Controller
{
    public function index(request $request){
        $query = Oeuvre::query();
        if($request->categorie_id){
            $query->where('categorie_id', $request->categorie_id);
        }
        if($request->theme_id){
            $query->whereHas('themes', function($q) use ($request){
                $q->where('themes.id', $request->theme_id);
            });
        }
        if($request->couleur_id){
            $query->whereHas('couleurs', function($q) use ($request){
                $q->where('couleurs.id', $request->couleur_id);
            });
        }  
        if($request->annee_min || $request->annee_max){
            $min = $request->annee_min ?? 1900;
            $max = $request->annee_max ?? date('Y');
            if($min > $max){
                $temp = $min;
                $min = $max;
                $max = $temp;
            }
            $query->whereBetween('annee_de_creation', [$min, $max]);
        }
        if($request->orientation){
            $query->where('orientation', $request->orientation);
        }
        if($request->recherche) {
            $query->where('titre', 'LIKE', '%'.$request->recherche.'%')
                ->orWhereHas('artiste', function($q) use ($request) {
                    $q->whereHas('user', function($q2) use ($request) {
                        $q2->where('nom', 'LIKE', '%'.$request->recherche.'%')
                        ->orWhere('prenom', 'LIKE', '%'.$request->recherche.'%');
                    });
                });
        }
     
        $oeuvres = $query->paginate(12);
        $annee_de_creation = Oeuvre::selectRaw('MIN(annee_de_creation) as min, MAX(annee_de_creation) as max')->first();
        $categories = Categorie::whereNull('id_categorie_parente')->get();
        $themes = Theme::all();
        $couleurs = Couleur::all();
        return view('catalogue.index', compact(
            'oeuvres',
            'annee_de_creation',
            'categories',
            'themes',
            'couleurs'
        ));
    }

    public function theme($theme){
        $oeuvres = Oeuvre::whereHas('themes', function($q) use ($theme){
            $q->where('id', $theme);
        })->paginate(12);
        return view('catalogue.theme', compact('oeuvres'));
    }

    public function categorie($categorie){
        $oeuvres = Oeuvre::all();
        $c = Categorie::where('nom_categorie', $categorie)->first();
        $oeuvresCategorie = $oeuvres->where('categorie_id', $c->id)->merge($oeuvres->where('id_categorie_parente', $c->id));
        return view('catalogue.categorie', compact('oeuvresCategorie', 'categorie'));
    }

    
}
