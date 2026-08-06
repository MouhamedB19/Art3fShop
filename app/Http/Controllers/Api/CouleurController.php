<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Couleur;
use App\Http\Resources\CouleurResource;
use Illuminate\Http\Request;

class CouleurController extends Controller
{
    public function index()
    {
        $couleurs = Couleur::all();
        return CouleurResource::collection($couleurs);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_couleur' => 'required | string'
        ]);

        $couleur = Couleur::create([
            'nom_couleur' => $data['nom_couleur']
        ]);

        return new CouleurResource($couleur);
    }

    public function update(Request $request,$couleur)
    {
        $couleurEnQuestion = Couleur::findOrFail($couleur);

        $data = $request->validate([
            'nom_theme' => 'required | string'
        ]);

        $couleur = Couleur::update([
            'nom_theme' => $data['nom_theme']
        ]);

        return new CouleurResource($couleur);
    }

    public function destroy($couleur)
    {
        $couleurEnQuestion = Couleur::findOrFail($couleur);
        $couleurEnQuestion->delete();
    }
}
