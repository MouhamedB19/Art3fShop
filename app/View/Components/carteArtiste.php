<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class carteArtiste extends Component
{
    /**
     * Create a new component instance.
     */
    public $artiste;
    public $nom;    
    public $ville;
    public $pays;
    public $oeuvrePhoto;
    public $nombreOeuvres;
 
    public function __construct($artiste)
    {
        $this->artiste = $artiste;

        $this->nom = $artiste->nom_d_artiste
            ?? ($artiste->user->nom . ' ' . $artiste->user->prenom);

        $this->ville = $artiste->localisation?->ville?->nom_ville;
        $this->pays = $artiste->localisation?->ville?->pays?->nom_pays;
        $this->oeuvrePhoto = $artiste->oeuvres->first()?->photo_principale;

        $this->nombreOeuvres = $artiste->oeuvres()
            ->where('visible', 1)
            ->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.carteArtiste');
    }
}
