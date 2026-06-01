<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Oeuvre;
use App\Models\Artiste;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    public function recherche(Request $request)
    {
        $q = $request->get('q');
        // logique de recherche...
        return view('recherche.index', compact('q', 'resultats'));
    }

    public function rechercheApi(Request $request)
    {
        $q = $request->get('q');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $oeuvres = Oeuvre::where('titre', 'like', "%{$q}%")
        ->with('artiste')
        ->limit(5)
        ->get()
        ->map(fn($o) => [
            'id'               => $o->id,
            'slug'             => $o->slug,
            'titre_highlighted'=> str_ireplace($q, "<b>{$q}</b>", $o->titre),
            'artiste'          => $o->artiste->nom,
            'photo_thumb'      => $o->photo_thumb_url,
            'prix'             => number_format($o->prix, 0, ',', ' '),
        ]);

        $artistes = Artiste::where('nom', 'like', "%{$q}%")
        ->limit(3)
        ->get()
        ->map(fn($a) => [
            'id'             => $a->id,
            'slug'           => $a->slug,
            'nom_highlighted'=> str_ireplace($q, "<b>{$q}</b>", $a->nom),
            'ville'          => $a->ville,
            'pays'           => $a->pays->nom,
            'photo'          => $a->photo_url,
        ]);

        $categories = collect(['Peinture','Sculpture','Photographie','Édition','Dessin'])
            ->filter(fn($c) => str_contains(strtolower($c), strtolower($q)))
            ->map(fn($c) => ['label' => $c, 'slug' => Str::slug($c)])
            ->values();

        return response()->json(compact('oeuvres', 'artistes', 'categories'));
    }

    public function changeLocale($locale)
    {
        // Vérifie que la locale est supportée
        if (in_array($locale, ['fr', 'en'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return redirect()->back();
    }

    public function changeDevise($devise)
    {
        if (in_array($devise, ['EUR', 'GBP', 'USD', 'CHF'])) {
            session(['devise' => $devise]);
        }
    
        return redirect()->back();
    }
    
    public function newsletterSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email'
        ]);
    
        NewsletterSubscriber::create([
            'user_id' => Auth::id(),
            'email'      => $request->email,
            'subscribed_at' => now(),
        ]);
    
        // Si appel AJAX (depuis le footer)
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
    
        return redirect()->back()->with('success', 'Merci pour votre inscription !');
    }
}
