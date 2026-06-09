<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Artiste;
use Illuminate\Http\Request;

class ArtisteController extends Controller
{
    public function index()
    {
        $artistes = Artiste::all();
        return view('artiste.index', compact('artistes'));
    }

    public function compte()
    {
        $artiste = Auth::user()->artiste;
        return view('artiste.compte', compact('artiste'));
    }

    public function inscription()
    {
        return view('artiste.inscription');
    }

    public function inscrire(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'telephone'   => 'nullable|string|max:20',
            'site_web'    => 'nullable|url',
            'biographie'  => 'required|string|min:100',
            'photo'       => 'required|image|max:5120',
        ]);

        $user = User::create([
            'nom'      => $request->nom,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'artiste',
        ]);

        $user->artiste()->create([
            'telephone'  => $request->telephone,
            'site_web'   => $request->site_web,
            'biographie' => $request->biographie,
            'photo'      => $request->file('photo')->store('artistes', 'public'),
        ]);

        Auth::login($user);

        return redirect()->route('artiste.compte')
            ->with('success', 'Bienvenue sur art3f Shop !');
    }

    public function show($id){
        $artiste = Artiste::with([
            'user',
            'localisation.ville.pays',
            'oeuvres' => fn($q) => $q->where('visible', true)->with(['tirages', 'categorie'])
        ])->findOrFail($id);
        return view('artistes.show',compact('artiste'));
    }
}
