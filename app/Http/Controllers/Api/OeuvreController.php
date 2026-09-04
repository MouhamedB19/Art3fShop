<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OeuvreResource;
use App\Models\Oeuvre;
use Symfony\Component\HttpFoundation\Response;

class OeuvreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   

    public function index(Request $request)
    {
        $query = Oeuvre::query();
        if($request->filled('theme'))
        {
            $query->whereHas('themes', function($q) use ($request){
                $q->where('nom_theme','like', '%' . $request->theme . '%');
            });
            return OeuvreResource::collection($query->get());
        }
        else if($request->filled('categorie'))
        {
            $query->where('id', $request->categorie);
            return OeuvreResource::collection($query->get());
        }
        else if($request->filled('couleur'))
        {
            $query->whereHas('couleurs', function($q) use ($request){
                $q->where('nom_couleur', 'like','%' . $request->couleur . '%');
            });
            return OeuvreResource::collection($query->get());
        }
        else
        {
            return response()->json([
                'message' => 'Paramètres de recherche manquants'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'annee_de_creation' => 'required|numeric',
            'taux_reduction' => 'nullable|numeric',
            'photo_principale' => 'required | string | max:255',
            'orientation' => 'nullable|string|max:255',
            'visible' => 'nullable|boolean',
            'categorie_id' => 'required|exists:categories,id',
            'support_id' => 'required|exists:supports,id',
            'artiste_id' => 'required|exists:artistes,id',

            'themes' => 'array',
            'themes.*' => 'exists:themes,id',

            'couleurs' => 'array',
            'couleurs.*' => 'exists:couleurs,id',
        ]);
        $oeuvre = Oeuvre::create([
            'titre' => $data['titre'],
            'description' => $data['description'] ?? null,
            'annee_de_creation' => $data['annee_de_creation'] ?? null,
            'photo_principale' => $data['photo_principale'],
            'taux_reduction' => $data['taux_reduction'] ?? null,
            'orientation' => $data['orientation'],
            'categorie_id' => $data['categorie_id'],
            'support_id' => $data['support_id'],
            'artiste_id' => $data['artiste_id'],
        ]);

        if (isset($data['themes'])) {
            $oeuvre->themes()->sync($data['themes']);
        }

        if (isset($data['couleurs'])) {
            $oeuvre->couleurs()->sync($data['couleurs']);
        }

        return new OeuvreResource($oeuvre);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new OeuvreResource(Oeuvre::with(['artiste'])->where('id', $id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'annee_de_creation' => 'required|numeric',
            'taux_reduction' => 'nullable|numeric',
            'photo_principale' => 'required | string | max:255',
            'orientation' => 'nullable|string|max:255',

            'categorie_id' => 'required|exists:categories,id',
            'support_id' => 'required|exists:supports,id',
            'artiste_id' => 'required|exists:artistes,id',

            'themes' => 'array',
            'themes.*' => 'exists:themes,id',

            'couleurs' => 'array',
            'couleurs.*' => 'exists:couleurs,id',
        ]);

        $oeuvre = Oeuvre::findOrFail($id);
        $oeuvre->update([
            'titre' => $data['titre'],
            'description' => $data['description'] ?? null,
            'annee_de_creation' => $data['annee_de_creation'] ?? null,
            'photo_principale' => $data['photo_principale'],
            'taux_reduction' => $data['taux_reduction'] ?? null,
            'orientation' => $data['orientation'],
            'categorie_id' => $data['categorie_id'],
            'support_id' => $data['support_id'],
            'artiste_id' => $data['artiste_id'],
            'updated_at' => now(),
        ]);

        if (isset($data['themes'])) {
            $oeuvre->themes()->sync($data['themes']);
        }

        if (isset($data['couleurs'])) {
            $oeuvre->couleurs()->sync($data['couleurs']);
        }

        return new OeuvreResource(
            $oeuvre
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $oeuvre = Oeuvre::findOrFail($id);
        $oeuvre->delete();
        return response()->json(['message' => 'Oeuvre supprimée avec succès']);
    }

    
}
