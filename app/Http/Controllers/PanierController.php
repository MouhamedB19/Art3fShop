<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tirage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;
class PanierController extends Controller
{
    // Afficher le panier
    public function index()
    {
        $client = Auth::user()->client;
        $tirages = $client->tirages;

        $total = $tirages->sum('prix');

        $reduction = 0;
        $totalFinal = $total;

        if (session('coupon_id')) {
            $coupon = Coupon::find(session('coupon_id'));

            if ($coupon) {
                $reduction = $coupon->type === 'pourcentage'
                    ? $total * $coupon->valeur / 100
                    : $coupon->valeur;

                // on évite une réduction qui dépasse le total
                $reduction = min($reduction, $total);

                $totalFinal = $total - $reduction;
            }
        }

        $coupons = Coupon::whereIn('id', session('coupons', []))->get();
        $reduction = $this->calculerReduction($total, $coupons);
        $totalFinal = $total - $reduction;

        return view('panier.index', compact('tirages', 'total', 'coupons', 'reduction', 'totalFinal'));
        
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

    private function calculerReduction($total, $coupons)
    {
        $reduction = 0;

        foreach ($coupons as $coupon) {
            $reduction += $coupon->type === 'pourcentage'
                ? $total * $coupon->valeur / 100
                : $coupon->valeur;
        }

        return min($reduction, $total); // jamais négatif
    }


}