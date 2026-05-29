<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Selection;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function index()
    {
        // Logique pour afficher les sélections
        $selections = Selection::where('active', true)->get();
        return view('selections.index', compact('selections'));
    }

    public function show($slug)
    {
        $selection = Selection::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();
    
        $oeuvres = $selection->oeuvres()->with('artiste')->get();
    
        return view('selections.show', compact('selection', 'oeuvres'));
    }
}
