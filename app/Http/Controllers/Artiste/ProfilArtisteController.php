<?php

namespace App\Http\Controllers\Artiste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Localisation;
use App\Models\Pays;
use App\Models\Categorie;
class ProfilArtisteController extends Controller
{
    public function index()
    {
        $pays = Pays::all();
        $villes = Localisation::select('villes.id', 'villes.nom_ville')
            ->join('villes', 'localisations.ville_id', '=', 'villes.id')
            ->distinct()
            ->get();
        $categories = Categorie::whereNull('id_categorie_parente')->get();
        return view('artiste.completer-profil', [
            'pays' => $pays,
            'villes' => $villes,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bio'          => ['required', 'string'],
            'nom_d_artiste' => ['string', 'max:255'],
            'photo'        => ['required', 'image', 'max:2048'],
            'iban'         => ['required', 'string'],
            'cv'           => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'code_postal'  => ['required', 'string'],
            'adresse'       => ['required', 'string'],
            'ville_id'     => ['required', 'exists:villes,id'],
            'categories' => ['required', 'array'],
        ]);

        $photo = $request->file('photo')->store('photos/artistes', 'public');

        // Cherche ou crée la localisation
        $localisation = Localisation::firstOrCreate([
            'code_postal' => $request->code_postal,
            'adresse'     => $request->adresse,
            'ville_id'    => $request->ville_id,
        ]);
        


        Auth::user()->artiste->update([
            'bio'              => $request->bio,
            'photo'            => $photo,
            'iban'             => $request->iban,
            'localisations_id' => $localisation->id,
            'nom_d_artiste'    => $request->nom_d_artiste,
            'cv'               => $request->file('cv')->store('cvs/artistes', 'public'),
        ]);
        Auth::user()->artiste->categories()->attach($request->categories);
        return redirect(route('dashboard'));
    }
}
