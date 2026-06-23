<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Calculs\CalculeReduction;
use Illuminate\Support\Facades\Auth;
use App\Models\Pays;
use App\Models\Ville;
use App\Models\Localisation;
use App\Models\Commande;
use App\Models\Tirage;

class CheckoutController extends Controller
{
    use CalculeReduction;
    public function resume()
    {
        $client = Auth::user()->client;
        $tirages = $client->tirages;
        $total = $tirages->sum('prix');

        $coupons = Coupon::whereIn('id', session('coupons', []))->get();
        $reduction = $this->calculerReduction($total, $coupons);

        return view('checkout.resume', compact('tirages', 'total', 'coupons', 'reduction'));
    }

    public function identification()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('redirect_after', route('checkout.identification'));
        }

        return view('checkout.identification', ['user' => Auth::user()]);
    }

    public function storeIdentification(Request $request)
    {
        // si rien à valider ici (déjà connecté), juste avancer
        return redirect()->route('checkout.adresse');
    }

    public function adresse()
    {
        $pays = Pays::orderBy('nom_pays')->get();
        $villes = Ville::orderBy('nom_ville')->get();

        return view('checkout.adresse', compact('pays', 'villes'));
    }

    public function storeAdresse(Request $request)
    {
        $validated = $request->validate([
            'adresse' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
            'ville_id' => 'required|exists:villes,id',
            'pays_id' => 'required|exists:pays,id',
        ]);

        // on vérifie si une localisation identique existe déjà, sinon on la crée
        $localisation = Localisation::firstOrCreate([
            'adresse' => $validated['adresse'],
            'code_postal' => $validated['code_postal'],
            'ville_id' => $validated['ville_id'],
        ]);

        session(['checkout.localisation_id' => $localisation->id]);

        return redirect()->route('checkout.livraison');
    }

    public function livraison()
    {
        $localisation = Localisation::find(session('checkout.localisation_id'));
        $pays = $localisation->ville->pays;

        $fraisOfferts = $pays->estDansUE($pays->nom_pays) ?? false; // adapte selon le nom réel de ta colonne

        return view('checkout.livraison', compact('fraisOfferts', 'pays'));
    }

    public function storeLivraison(Request $request)
    {
        session([
            'checkout.est_cadeau' => $request->boolean('est_cadeau'),
            'checkout.message_cadeau' => $request->message_cadeau,
        ]);

        return redirect()->route('checkout.paiement');
    }

    public function paiement()
    {
        $client = Auth::user()->client;
        $total = $client->tirages->sum('prix');
        $coupons = Coupon::whereIn('id', session('coupons', []))->get();
        $reduction = $this->calculerReduction($total, $coupons);
        $totalFinal = $total - $reduction;

        return view('checkout.paiement', compact('totalFinal'));
    }

    public function storePaiement(Request $request)
    {
        // on simule juste un check carte basique, pas de vraie validation bancaire
        $request->validate([
            'numero_carte' => 'required|string|min:12',
            'date_expiration' => 'required|string',
            'cvc' => 'required|string|min:3|max:4',
        ]);

        // ici tu crées la vraie Commande avec tout ce qu'on a en session
        $client = Auth::user()->client;
        $tirages = $client->tirages;

        $commande = Commande::create([
            'user_id' => Auth::id(),
            'date_commande' => now(),
            'est_cadeau' => session('checkout.est_cadeau', false),
            'message_cadeau' => session('checkout.message_cadeau'),
        ]);

        Tirage::whereIn('id', $tirages->pluck('id'))->update(['commande_id' => $commande->id]);

        $coupons = Coupon::whereIn('id', session('coupons', []))->get();
        if ($coupons->isNotEmpty()) {
            $commande->coupons()->attach($coupons->pluck('id'));
            Coupon::whereIn('id', $coupons->pluck('id'))->increment('nombre_utilisations');
        }

        $client->tirages()->detach();
        session()->forget(['coupons', 'checkout.adresse', 'checkout.localisation_id', 'checkout.fdp_offerts', 'checkout.est_cadeau', 'checkout.message_cadeau']);

        return redirect()->route('checkout.confirmation', $commande)->with('success', 'Paiement validé !');
    }

    public function confirmation(Commande $commande)
    {
        // sécurité : on vérifie que c'est bien la commande de l'utilisateur connecté
        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.confirmation', compact('commande'));
    }
}
