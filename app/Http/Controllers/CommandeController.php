<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\Commande;
use App\Models\Tirage;

class CommandeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user)
        {
            $commandes = $user->commandes()->get();
            return view('compte.commandes.index',compact('commandes'));
        }
    }

    public function show($id)
    {
        $commande = Auth::user()
                    ->commandes()
                    ->with(['tirages.oeuvre.artiste.user', 'livraisons', 'conversation'])
                    ->findOrFail($id);
        return view('compte.commandes.show',compact('commande'));
    }

    // CommandeController
    public function create()
    {
        $client = Auth::user()->client;
        $tirages = $client->tirages;
        $total = $tirages->sum('prix');

        $reduction = 0;
        if (session('coupon_id') && $coupon = Coupon::find(session('coupon_id'))) {
            $reduction = $coupon->type === 'pourcentage' ? $total * $coupon->valeur / 100 : $coupon->valeur;
            $reduction = min($reduction, $total);
        }

        return view('compte.commande.checkout', compact('tirages', 'total', 'reduction'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'est_cadeau' => 'nullable|boolean',
            'message_cadeau' => 'nullable|string|max:300',
        ]);

        $client = Auth::user()->client;
        $tirages = $client->tirages;

        $commande = Commande::create([
            'user_id' => Auth::id(),
            'date_commande' => now(),
            'est_cadeau' => $request->boolean('est_cadeau'),
            'message_cadeau' => $validated['message_cadeau'] ?? null,
        ]);

        Tirage::whereIn('id', $tirages->pluck('id'))->update(['commande_id' => $commande->id]);

        if (session('coupon_id')) {
            $commande->coupons()->attach(session('coupon_id'));

            Coupon::find(session('coupon_id'))?->increment('utilisations_actuelles');
        }

        $client->tirages()->detach();
        session()->forget('coupon_id');

        return redirect()->route('commande.confirmation', $commande)->with('success', 'Commande passée !');
    }
}
