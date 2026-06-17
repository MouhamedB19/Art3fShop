<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Oeuvre;
use App\Models\Tirage;
use App\Models\Dimension;
use App\Models\Categorie;
use App\Models\Support;
use App\Models\Theme;
use App\Models\Couleur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OeuvreController extends Controller
{
    /**
     * Liste des œuvres de l'artiste connecté.
     */
    public function index()
    {
        $oeuvres = Oeuvre::with(['tirages', 'categorie'])
            ->where('artiste_id', Auth::user()->artiste->id)
            ->latest()
            ->get();

        return view('oeuvres.index', compact('oeuvres'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $categories = Categorie::orderBy('nom_categorie')->get();
        $supports   = Support::orderBy('nom_support')->get();
        $themes     = Theme::orderBy('nom_theme')->get();
        $couleurs   = Couleur::orderBy('nom_couleur')->get();

        return view('oeuvres.create', compact('categories', 'supports', 'themes', 'couleurs'));
    }

    /**
     * Enregistrement de l'œuvre + ses tirages.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre'             => 'required|string|max:255',
            'annee_de_creation' => 'required|integer|min:1900|max:' . date('Y'),
            'taux_reduction'    => 'nullable|numeric|min:0|max:0.99',
            'photo_principale'  => 'required|image|mimes:jpeg,png,tiff|max:10240|dimensions:min_width=600,min_height=600',
            'orientation'       => 'required|in:portrait,paysage,carre',
            'description'       => 'required|string',
            'visible'           => 'boolean',
            'categorie_id'      => 'required|exists:categories,id',
            'support_id'        => 'required|exists:supports,id',
            'themes'            => 'nullable|array',
            'themes.*'          => 'exists:themes,id',
            'couleurs'          => 'nullable|array',
            'couleurs.*'        => 'exists:couleurs,id',

            // Tirages
            'tirages'                     => 'required|array|min:1',
            'tirages.*.numero'            => 'required|integer|min:1',
            'tirages.*.prix'              => 'required|numeric|min:0',
            'tirages.*.status'            => 'required|in:disponible,vendu,reserve',
            'tirages.*.largeur'           => 'required|numeric|min:1',
            'tirages.*.hauteur'           => 'required|numeric|min:1',
            'tirages.*.encadrement'       => 'required|in:0 , 1',
            'tirages.*.pret_a_accrocher'  => 'nullable|boolean',
            'tirages.*.avec_cadre'        => 'nullable|boolean',
        ]);

        // 1. Upload photo principale
        $photoPath = $request->file('photo_principale')->store('oeuvres', 'public');

        // 2. Créer l'œuvre
        $oeuvre = Oeuvre::create([
            'titre'             => $request->titre,
            'annee_de_creation' => $request->annee_de_creation,
            'taux_reduction'    => $request->taux_reduction,
            'photo_principale'  => $photoPath,
            'orientation'       => $request->orientation,
            'description'       => $request->description,
            'visible'           => $request->boolean('visible', true),
            'categorie_id'      => $request->categorie_id,
            'support_id'        => $request->support_id,
            'artiste_id'        => Auth::user()->artiste->id,
        ]);

        // 3. Sync thèmes & couleurs
        if ($request->has('themes')) {
            $oeuvre->themes()->sync($request->themes);
        }
        if ($request->has('couleurs')) {
            $oeuvre->couleurs()->sync($request->couleurs);
        }

        // 4. Créer les tirages
        foreach ($request->tirages as $tirageData) {
            // firstOrCreate pour éviter les doublons de dimensions
            $dimension = Dimension::firstOrCreate([
                'largeur' => $tirageData['largeur'],
                'hauteur' => $tirageData['hauteur'],
            ]);

            Tirage::create([
                'oeuvre_id'         => $oeuvre->id,
                'numero'            => $tirageData['numero'],
                'prix'              => $tirageData['prix'],
                'status'            => $tirageData['status'],
                'encadrement'       => (bool) ($tirageData['encadrement'] ?? false),
                'pret_a_accrocher'  => (bool) ($tirageData['pret_a_accrocher'] ?? false),
                'avec_cadre'        => (bool) ($tirageData['avec_cadre'] ?? false),
                'dimensions_id'     => $dimension->id,
            ]);
        }

        return redirect()
            ->route('oeuvres.index')
            ->with('success', 'Œuvre publiée avec succès !');
    }

    /**
     * Fiche œuvre (vue artiste).
     */
    public function show(Oeuvre $oeuvre)
    {
        $this->authorizeOeuvre($oeuvre);

        $oeuvre->load(['tirages.dimension', 'categorie', 'support', 'themes', 'couleurs']);

        return view('oeuvres.index', compact('oeuvre'));
    }

    /**
     * Formulaire d'édition.
     */
    public function edit(Oeuvre $oeuvre)
    {
        $this->authorizeOeuvre($oeuvre);

        $oeuvre->load(['tirages.dimension', 'themes', 'couleurs']);

        $categories = Categorie::orderBy('nom_categorie')->get();
        $supports   = Support::orderBy('nom_support')->get();
        $themes     = Theme::orderBy('nom_theme')->get();
        $couleurs   = Couleur::orderBy('nom_couleur')->get();

        return view('oeuvres.edit', compact('oeuvre', 'categories', 'supports', 'themes', 'couleurs'));
    }

    /**
     * Mise à jour de l'œuvre + ses tirages.
     */
    public function update(Request $request, Oeuvre $oeuvre)
    {
        $this->authorizeOeuvre($oeuvre);

        $request->validate([
            'titre'             => 'required|string|max:255',
            'annee_de_creation' => 'required|integer|min:1900|max:' . date('Y'),
            'taux_reduction'    => 'nullable|numeric|min:0|max:0.99',
            'photo_principale'  => 'nullable|image|mimes:jpeg,png,tiff|max:10240|dimensions:min_width=600,min_height=600',
            'orientation'       => 'required|in:portrait,paysage,carre',
            'description'       => 'required|string',
            'visible'           => 'boolean',
            'categorie_id'      => 'required|exists:categories,id',
            'support_id'        => 'required|exists:supports,id',
            'themes'            => 'nullable|array',
            'themes.*'          => 'exists:themes,id',
            'couleurs'          => 'nullable|array',
            'couleurs.*'        => 'exists:couleurs,id',

            'tirages'                     => 'required|array|min:1',
            'tirages.*.numero'            => 'required|integer|min:1',
            'tirages.*.prix'              => 'required|numeric|min:0',
            'tirages.*.status'            => 'required|in:disponible,vendu,reserve',
            'tirages.*.largeur'           => 'required|numeric|min:1',
            'tirages.*.hauteur'           => 'required|numeric|min:1',
            'tirages.*.encadrement'       => 'required|in:sans,avec',
            'tirages.*.pret_a_accrocher'  => 'nullable|boolean',
            'tirages.*.avec_cadre'        => 'nullable|boolean',
        ]);

        // 1. Photo principale (optionnelle en update)
        $photoPath = $oeuvre->photo_principale;
        if ($request->hasFile('photo_principale')) {
            Storage::disk('public')->delete($photoPath);
            $photoPath = $request->file('photo_principale')->store('oeuvres', 'public');
        }

        // 2. Mettre à jour l'œuvre
        $oeuvre->update([
            'titre'             => $request->titre,
            'annee_de_creation' => $request->annee_de_creation,
            'taux_reduction'    => $request->taux_reduction,
            'photo_principale'  => $photoPath,
            'orientation'       => $request->orientation,
            'description'       => $request->description,
            'visible'           => $request->boolean('visible', true),
            'categorie_id'      => $request->categorie_id,
            'support_id'        => $request->support_id,
        ]);

        // 3. Sync thèmes & couleurs
        $oeuvre->themes()->sync($request->themes ?? []);
        $oeuvre->couleurs()->sync($request->couleurs ?? []);

        // 4. Recréer les tirages (delete + insert)
        // On supprime uniquement les tirages non vendus pour ne pas casser l'historique
        $oeuvre->tirages()->where('status', '!=', 'vendu')->delete();

        foreach ($request->tirages as $tirageData) {
            $dimension = Dimension::firstOrCreate([
                'largeur' => $tirageData['largeur'],
                'hauteur' => $tirageData['hauteur'],
            ]);

            Tirage::create([
                'oeuvre_id'         => $oeuvre->id,
                'numero'            => $tirageData['numero'],
                'prix'              => $tirageData['prix'],
                'status'            => $tirageData['status'],
                'encadrement'       => $tirageData['encadrement'],
                'pret_a_accrocher'  => (bool) ($tirageData['pret_a_accrocher'] ?? false),
                'avec_cadre'        => (bool) ($tirageData['avec_cadre'] ?? false),
                'dimensions_id'     => $dimension->id,
            ]);
        }

        return redirect()
            ->route('oeuvres.index')
            ->with('success', 'Œuvre mise à jour avec succès !');
    }

    /**
     * Suppression de l'œuvre.
     */
    public function destroy(Oeuvre $oeuvre)
    {
        $this->authorizeOeuvre($oeuvre);

        Storage::disk('public')->delete($oeuvre->photo_principale);
        $oeuvre->delete();

        return redirect()
            ->route('oeuvres.index')
            ->with('success', 'Œuvre supprimée.');
    }

    /**
     * Vérifie que l'artiste connecté est bien propriétaire de l'œuvre.
     */
    private function authorizeOeuvre(Oeuvre $oeuvre): void
    {
        abort_if($oeuvre->artiste_id !== Auth::user()->artiste->id, 403);
    }
}