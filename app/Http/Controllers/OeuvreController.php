<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oeuvre;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Support;
use App\Models\Theme;
use App\Models\Tirage;
use Illuminate\Support\Facades\Auth;
class OeuvreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oeuvres = Oeuvre::where('artiste_id', Auth::user()->artiste->id)->get();
        return view('oeuvres.index', compact('oeuvres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::whereNull('id_categorie_parente')->get();
        $couleurs = Couleur::all();
        $supports = Support::all();
        $themes = Theme::all();
        return view('oeuvres.create', compact('categories', 'couleurs', 'supports', 'themes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre'           => ['required', 'string', 'max:255'],
            'annee_de_creation'  => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'categorie_id'    => ['required', 'exists:categories,id'],
            'support_id'      => ['required', 'exists:supports,id'],
            'orientation'     => ['required', 'in:portrait,paysage,carre'],
            'photo_principale'=> ['required', 'image', 'max:2048'],
            'description'     => ['required', 'string'],
            'themes'          => ['required', 'array'],
            'couleurs'        => ['required', 'array'],
        ]);

        // Upload photo
        $photo = $request->file('photo_principale')
                         ->store('photos/oeuvres', 'public');

        // Créer l'oeuvre
        $oeuvre = Oeuvre::create([
            'titre'            => $request->titre,
            'annee_de_creation'   => $request->annee_de_creation,
            'categorie_id'     => $request->categorie_id,
            'support_id'       => $request->support_id,
            'orientation'      => $request->orientation,
            'photo_principale' => $photo,
            'description'      => $request->description,
            'encadrement'      => $request->boolean('encadrement'),
            'artiste_id'       => Auth::user()->artiste->id,
        ]);

        // Lier les thèmes et couleurs
        $oeuvre->themes()->attach($request->themes);
        $oeuvre->couleurs()->attach($request->couleurs);

        return redirect(route('oeuvres.index'))->with('success', 'Œuvre ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    // OeuvreController.php
    public function show($id)
    {
        
        $tirage = Tirage::where('id', $id)->with('oeuvre')->firstOrFail();
        // Autres œuvres du même artiste (pour le bandeau en bas)
        $autresOeuvres = Oeuvre::where('artiste_id', $oeuvre->artiste_id)
            ->where('id', '!=', $oeuvre->id)
            ->where('visible', true)
            ->with(['tirages', 'artiste.user'])
            ->take(6)
            ->get();

        return view('oeuvres.show', compact('tirage', 'autresOeuvres'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Oeuvre $oeuvre)
    {
        $categories = Categorie::whereNull('id_categorie_parente')->get();
        $couleurs = Couleur::all();
        $supports = Support::all();
        $themes = Theme::all();
        return view('oeuvres.edit', compact('oeuvre', 'categories', 'couleurs', 'supports', 'themes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Oeuvre $oeuvre)
    {
        $request->validate([
            'titre'            => ['required', 'string', 'max:255'],
            'categorie_id'     => ['required', 'exists:categories,id'],
            'support_id'       => ['required', 'exists:supports,id'],
            'description'      => ['required', 'string'],
            'themes'           => ['required', 'array'],
            'couleurs'         => ['required', 'array'],
        ]);

        // Mise à jour photo si nouvelle photo uploadée
        if($request->hasFile('photo_principale')) {
            $photo = $request->file('photo_principale')->store('photos/oeuvres', 'public');
            $oeuvre->photo_principale = $photo;
        }

        $oeuvre->update([
            'titre'          => $request->titre,
            'categorie_id'   => $request->categorie_id,
            'support_id'     => $request->support_id,
            'orientation'    => $request->orientation,
            'description'    => $request->description,
            'encadrement'    => $request->boolean('encadrement'),
        ]);

        // Sync thèmes et couleurs
        $oeuvre->themes()->sync($request->themes);
        $oeuvre->couleurs()->sync($request->couleurs);

        return redirect(route('oeuvres.index'))->with('success', 'Œuvre modifiée avec succès !');
    }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Oeuvre $oeuvre)
        {
            $oeuvre->themes()->detach();
            $oeuvre->couleurs()->detach();
            $oeuvre->delete();
            return redirect(route('oeuvres.index'))->with('success', 'Œuvre supprimée avec succès !');
        }
    }
