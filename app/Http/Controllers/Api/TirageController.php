<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TirageResource;
use Illuminate\Http\Request;
use App\Models\Tirage;
use App\Models\Dimension;

class TirageController extends Controller
{
    public function listeTiragesDuneOeuvre($oeuvreId)
    {
        $tirages = Tirage::where('oeuvre_id', $oeuvreId)->get();
        return TirageResource::collection($tirages);
    }

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

        
        if ($request->filled('categorie')) {
            $tirages->whereHas('oeuvre.categorie', function ($query) use ($request) {
                $query->where('categories.id', $request->categorie);
            });
        }

        
        if ($request->filled('couleurs')) {
            $tirages->whereHas('oeuvre.couleurs', function ($query) use ($request) {
                $query->where('couleurs.id', $request->couleurs);
            });
        }

        return TirageResource::collection($tirages->get());
    }
}
