<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
