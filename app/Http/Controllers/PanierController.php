<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tirage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    // Afficher le panier
    public function index()
    {
        $client = Auth::user()->client;
        $tirages = $client->tirages()->with('oeuvre.artiste.user')->get();

        $total = $tirages->sum(fn($t) => $t->prix * $t->pivot->quantite);

        return view('panier.index', compact('tirages', 'total'));
    }

    // Ajouter un tirage au panier
    public function add(Request $request, Tirage $tirage)
    {
        $client = Auth::user()->client;

        // Si déjà dans le panier, on incrémente
        if ($client->tirages()->where('tirage_id', $tirage->id)->exists()) {
            $client->tirages()->updateExistingPivot($tirage->id, [
                'quantite' => DB::raw('quantite + ' . ($request->quantite ?? 1))
            ]);
        } else {
            $client->tirages()->attach($tirage->id, [
                'quantite' => $request->quantite ?? 1
            ]);
        }

        return back()->with('success', 'Tirage ajouté au panier !');
    }

    // Mettre à jour la quantité
    public function update(Request $request, Tirage $tirage)
    {
        $request->validate(['quantite' => 'required|integer|min:1']);

        $client = Auth::user()->client;
        $client->tirages()->updateExistingPivot($tirage->id, [
            'quantite' => $request->quantite
        ]);

        return back()->with('success', 'Quantité mise à jour.');
    }

    // Supprimer un tirage du panier
    public function remove(Tirage $tirage)
    {
        $client = Auth::user()->client;
        $client->tirages()->detach($tirage->id);

        return back()->with('success', 'Tirage retiré du panier.');
    }

    // Vider le panier
    public function clear()
    {
        $client = Auth::user()->client;
        $client->tirages()->detach();

        return back()->with('success', 'Panier vidé.');
    }
}