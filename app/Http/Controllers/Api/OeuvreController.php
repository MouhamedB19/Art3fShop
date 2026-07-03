<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OeuvreResource;
use App\Models\Oeuvre;

class OeuvreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OeuvreResource::collection(Oeuvre::with([
            'artiste',
            'categorie',
            'support',
            'artiste.user',
            'themes',
            'couleurs'
        ])->get());
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

        return new OeuvreResource(
            $oeuvre
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return OeuvreResource::collection(Oeuvre::with(['artiste'])->where('id', $id)->get());
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
        //
    }
}
