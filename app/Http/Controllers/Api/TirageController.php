<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TirageResource;
use Illuminate\Http\Request;
use App\Models\Tirage;
use App\Models\Dimension;

class TirageController extends Controller
{
    

    public function show($id)
    {
        $tirage = Tirage::findOrFail($id);
        return new TirageResource($tirage);
    }

    public function addToOeuvre(Request $request, $id)
    {
        $tirage = $request->validate([
            'numero' => 'integer',
            'prix' => 'required|numeric',
            'status' => 'in:disponible,vendu',
            'encadrement' => 'boolean',
            'dimensions_id' => 'exists:dimensions,id',
            'pret_a_accrocher' => 'boolean',
            'commande_id' => 'nullable|exists:commandes,id',
            'avec_cadre' => 'boolean',
            'largeur' => 'required|numeric',
            'hauteur' => 'required|numeric',
        ]);



        $dim = Dimension::firstOrCreate([
            'largeur' => $tirage['largeur'],
            'hauteur' => $tirage['hauteur'],
        ]);
        $nbTirages = Tirage::where('oeuvre_id', $id)->count();
        $tirage = Tirage::create([
            'oeuvre_id' => $id,
            'numero' => $nbTirages + 1,
            'prix' => $tirage['prix'],
            'status' => $tirage['status'] ?? 'disponible',
            'dimensions_id' => $dim->id,
            'encadrement' => $tirage['encadrement'] ?? false,
            'pret_a_accrocher' => $tirage['pret_a_accrocher'] ?? false,
            'commande_id' => $tirage['commande_id'] ?? null,
            'avec_cadre' => $tirage['avec_cadre'] ?? false,
        ]);

        return new TirageResource($tirage);
    }

    public function destroy($id)
    {
        $tirage = Tirage::findOrFail($id);
        $tirage->delete();

        return response()->json(['message' => 'Tirage supprimé avec succès', 'code' => 200]);
    }

    public function index(Request $request)
    {
        $tirages = Tirage::query()
            ->with([
                'oeuvre',
                'oeuvre.themes',
                'oeuvre.couleurs',
                'oeuvre.categorie',
            ]);

        // Filtre par thème
        if ($request->filled('themes')) {
            $tirages->whereHas('oeuvre.themes', function ($query) use ($request) {
                $query->where('themes.id', $request->themes);
            });
        }

        //filtre par catégorie
        if ($request->filled('categorie')) {
            $tirages->whereHas('oeuvre.categorie', function ($query) use ($request) {
                $query->where('categories.id', $request->categorie);
            });
        }

        // filtre par couleurs
        if ($request->filled('couleurs')) {
            $tirages->whereHas('oeuvre.couleurs', function ($query) use ($request) {
                $query->where('couleurs.id', $request->couleurs);
            });
        }

        // filtre par prix
        if($request->filled('prix_min'))
        {
            if($request->filled('prix_max'))
            {
                $tirages->whereBetween('prix',[$request->prix_min, $request->prix_max]);
            }
            else
            {
                $tirages->where('prix','>=',$request->prix_min);
            }
        }
        else if($request->filled('prix_max'))
        {
            $tirages->where('prix','<=',$request->prix_max);
        }

        // filtre par orientation
        if($request->filled('orientation'))
        {
            $tirages->whereHas('oeuvre', function ($query) use ($request){
                $query->where('orientation', $request->orientation);
            });
        }
        return TirageResource::collection($tirages->get());
    }
}
