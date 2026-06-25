<?php

// app/Http/Controllers/RechercheController.php
namespace App\Http\Controllers;

use App\Models\Oeuvre;
use App\Models\Artiste;
use App\Models\Categorie;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function suggestions(Request $request)
    {
        $terme = $request->query('q', '');

        if (mb_strlen($terme) < 2) {
            return response()->json([
                'oeuvres' => [],
                'artistes' => [],
                'categories' => [],
            ]);
        }

        $oeuvres = Oeuvre::search($terme)->take(5)->get()->map(function ($oeuvre) use ($terme) {
            $prixMin = $oeuvre->tirages()
                ->where('status', true) // ou le statut/champ qui indique "pas encore vendu"
                ->min('prix');

            $tirageDispo = $oeuvre->tirages()->where('status', 'disponible')->min('prix');

            return [
                'id' => $oeuvre->id,
                'photo_thumb' => asset('storage/' . $oeuvre->image),
                'titre_highlighted' => $this->highlight($oeuvre->titre, $terme),
                'artiste' => $oeuvre->artiste
                    ? ($oeuvre->artiste->nom_d_artiste ?: $oeuvre->artiste->user->nom . ' ' . $oeuvre->artiste->user->prenom)
                    : null,
                'prix' => $tirageDispo,
                'vendu' => $tirageDispo === null,
            ];
        });

        $artistes = Artiste::search($terme)->take(3)->get()->map(function ($artiste) use ($terme) {
            $nomAffiche = $artiste->nom_d_artiste ?: $artiste->user->nom . ' ' . $artiste->user->prenom;
            return [
                'id' => $artiste->id,
                'photo' => asset('storage/' . $artiste->photo),
                'nom_highlighted' => $this->highlight($nomAffiche, $terme),
                'ville' => $artiste->user->localisation->ville->nom_ville ?? '',
                'pays' => $artiste->user->localisation->ville->pays->nom_pays ?? '',
            ];
        });

        $categories = Categorie::search($terme)->take(3)->get()->map(function ($categorie) {
            return [
                'id' => $categorie->id,
                'label' => $categorie->nom_categorie,
            ];
        });



        return response()->json([
            'oeuvres' => $oeuvres,
            'artistes' => $artistes,
            'categories' => $categories,
        ]);
    }

    private function highlight(string $texte, string $terme): string
    {
        return preg_replace(
            '/(' . preg_quote($terme, '/') . ')/iu',
            '<strong>$1</strong>',
            $texte
        );
    }

    public function index(Request $request)
    {
        $terme = $request->query('q', '');
    
        $oeuvres = Oeuvre::search($terme)
            ->query(fn ($query) => $query->with(['artiste.user', 'tirages']))
            ->paginate(12, 'page_oeuvres')
            ->appends($request->query());
    
        $artistes = Artiste::search($terme)
            ->query(fn ($query) => $query->with(['user', 'localisation.ville.pays']))
            ->paginate(8, 'page_artistes')
            ->appends($request->query());
    
        $categories = Categorie::search($terme)->get();

    return view('recherche.index', compact('oeuvres', 'artistes', 'categories', 'terme'));
}
}
