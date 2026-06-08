<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

public class CarteOeuvre extends Component{
    public $oeuvre;
    public $tirage;
    public $prixAffiche;
    public $isNew;
    public $vendu;
    public $prix;



    public function __construct($oeuvre = null,
                        $tirage = null,
                        $prix = 0,
                        $prixAffiche = 0,
                        $isNew = false,
                        $vendu = false)
    {
        $this->oeuvre = $oeuvre;
        $this->tirage = $tirage;
        $this->prix = prix;
        $this->prixAffiche = $prixAffiche;
        $this->isNew = $isNew;
        $this->vendu = $vendu;
    }

    public function render(): View|Closure|string
    {
        return view('components.carte-oeuvre');
    }
};