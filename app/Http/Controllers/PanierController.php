<?php

namespace App\Http\Controllers;
use App\Calculs\CalculeReduction;
use Illuminate\Http\Request;
use App\Models\Tirage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;



class PanierController extends Controller
{
    use CalculeReduction;
    // Afficher le panier
    public function index()
    {
        $client = Auth::user()->client;
        $tirages = $client->tirages;
        $total = 0;

        foreach($tirages as $t){
            if($t->oeuvre->taux_reduction)
                $total += $t->prix * (1 - $t->oeuvre->taux_reduction); 
            else
                $total += $t->prix;
        }
        

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
        if(Auth::user() && Auth::user()->estClient())
        {
            $client = Auth::user()->client;

            // Si déjà dans le panier, on le retire
            if ($client->tirages()->where('tirage_id', $tirage->id)->exists()) {
                $client->tirages()->detach($tirage->id);
            } 
            else {
                $client->tirages()->attach($tirage->id);
            }

            return back()->with('success', 'Tirage ajouté au panier !');
        }
        else{
            return redirect()->route('login')->with('error','Vous devez d\'abord vous connecter avec une compte client');
        }
        
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