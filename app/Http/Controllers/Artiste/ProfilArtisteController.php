<?php

namespace App\Http\Controllers\Artiste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Localisation;
use App\Models\Pays;

class ProfilArtisteController extends Controller
{
    public function index()
    {
        $pays = Pays::all();
        $villes = Localisation::select('villes.id', 'villes.nom_ville')
            ->join('villes', 'localisations.ville_id', '=', 'villes.id')
            ->distinct()
            ->get();
        return view('artiste.completer-profil', [
            'pays' => $pays,
            'villes' => $villes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bio'          => ['required', 'string'],
            'photo'        => ['required', 'image', 'max:2048'],
            'iban'         => ['required', 'string'],
            'code_postal'  => ['required', 'string'],
            'ville_id'     => ['required', 'exists:villes,id'],
        ]);

        $photo = $request->file('photo')->store('photos/artistes', 'public');

        // Cherche ou crée la localisation
        $localisation = Localisation::firstOrCreate([
            'code_postal' => $request->code_postal,
            'ville_id'    => $request->ville_id,
        ]);

        Auth::user()->artiste->update([
            'bio'              => $request->bio,
            'photo'            => $photo,
            'iban'             => $request->iban,
            'localisations_id' => $localisation->id,
        ]);

        return redirect(route('dashboard'));
    }
}
