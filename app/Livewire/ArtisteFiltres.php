<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Component;
use Illuminate\Http\Request;
use App\Models\Artiste;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Theme;
use App\Models\Tirage;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\auth;

new class extends Component
{
    //
    use WithPagination;
 
    // ── Artiste courant ──────────────────────────────────────────
    public Artiste $artiste;
 
    // ── Filtres (wire:model dans la vue) ────────────────────────
    public string $categorie   = '';
    public string $theme       = '';
    public string $couleur     = '';
    public string  $encadrement = '';   // '' | '1' | '0'
    public string $orientation = '';   // '' | 'paysage' | 'portrait' | 'carre'
    public int    $prix_min    = 0;
    public int    $prix_max    = 5000;
    public int    $hauteur_min = 0;
    public int    $hauteur_max = 500;
    public int    $largeur_min = 0;
    public int    $largeur_max = 500;
 
    // ── Réinitialiser la pagination quand un filtre change ───────
    protected $queryString = [
        'categorie', 'theme', 'couleur', 'encadrement',
        'orientation', 'prix_min', 'prix_max',
        'hauteur_min', 'hauteur_max', 'largeur_min', 'largeur_max',
    ];
    public function supprimerFiltre(string $cle): void
    {
        $defaults = [
            'categorie'   => '', 'theme'       => '',
            'couleur'     => '', 'encadrement' => '',
            'orientation' => '',
            'prix_min'    => 0,  'prix_max'    => 5000,
            'hauteur_min' => 0,  'hauteur_max' => 500,
            'largeur_min' => 0,  'largeur_max' => 500,
        ];
 
        if (array_key_exists($cle, $defaults)) {
            $this->$cle = $defaults[$cle];
            $this->resetPage();
        }
    }
 
    // ── Tout réinitialiser ───────────────────────────────────────
    public function resetFiltres(): void
    {
        $this->categorie = $this->theme = $this->couleur =
        $this->encadrement = $this->orientation = '';
        $this->prix_min = $this->hauteur_min = $this->largeur_min = 0;
        $this->prix_max = 5000;
        $this->hauteur_max = $this->largeur_max = 500;
        $this->resetPage();
    }

 
    // ── Coup de cœur (toggle depuis la grille) ───────────────────
    public function toggleCoeur(int $oeuvreId): void
    {
        if (! Auth::check()) {
            $this->emit('redirect-login');
            return;
        }
 
        $user = Auth::user();
 
        if ($user->aimeOeuvre($oeuvreId)) {
            $user->oeuvresFavoris()->detach($oeuvreId);
        } else {
            // Max 5 œuvres coup de cœur
            if ($user->oeuvresFavoris()->count() >= 5) {
                $this->emit('notify', ['type' => 'warning', 'message' => 'Vous avez atteint la limite de 5 œuvres coup de cœur.']);
                return;
            }
            $user->oeuvresFavoris()->attach($oeuvreId);
        }
    }
 
    // ── Liste des filtres actifs pour affichage des tags ────────
    public function getFiltresActifsProperty(): \Illuminate\Support\Collection
    {
        return collect($this->filtresActifsArray());
    }
 
    private function filtresActifsArray(): array
    {
        $actifs = [];
 
        if ($this->categorie)   $actifs['categorie']   = Categorie::whereSlug($this->categorie)->value('nom') ?? $this->categorie;
        if ($this->theme)       $actifs['theme']       = Theme::whereSlug($this->theme)->value('nom') ?? $this->theme;
        if ($this->couleur)     $actifs['couleur']     = Couleur::whereSlug($this->couleur)->value('nom') ?? $this->couleur;
        if ($this->encadrement !== '') $actifs['encadrement'] = $this->encadrement ? 'Encadré' : 'Non encadré';
        if ($this->orientation) $actifs['orientation'] = ucfirst($this->orientation);
        if ($this->prix_min > 0)     $actifs['prix_min']    = 'Min ' . $this->prix_min . ' €';
        if ($this->prix_max < 5000)  $actifs['prix_max']    = 'Max ' . $this->prix_max . ' €';
        if ($this->hauteur_min > 0)  $actifs['hauteur_min'] = 'H min ' . $this->hauteur_min . ' cm';
        if ($this->hauteur_max < 500) $actifs['hauteur_max'] = 'H max ' . $this->hauteur_max . ' cm';
        if ($this->largeur_min > 0)  $actifs['largeur_min'] = 'L min ' . $this->largeur_min . ' cm';
        if ($this->largeur_max < 500) $actifs['largeur_max'] = 'L max ' . $this->largeur_max . ' cm';
 
        return $actifs;
    }
 
    // ── Render ───────────────────────────────────────────────────
    public function render()
    {
        // Œuvres de cet artiste uniquement, visibles, filtrées
        $query = $this->artiste
            ->oeuvres()
            ->visible()                                   // scope : visible = true
            ->with(['categorie', 'tags'])
            ->orderByDesc('created_at');                  // NEW en premier
 
        // --- Filtres ---
        if ($this->categorie) {
            $query->whereHas('categorie', fn($q) => $q->where('slug', $this->categorie));
        }
        if ($this->theme) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $this->theme)->where('type', 'theme'));
        }
        if ($this->couleur) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $this->couleur)->where('type', 'couleur'));
        }
        if ($this->encadrement !== '') {
            $query->where('encadrement', (bool) $this->encadrement);
        }
        if ($this->orientation) {
            $query->where('orientation', $this->orientation);
        }
        if ($this->prix_min > 0) {
            $query->where('prix', '>=', $this->prix_min);
        }
        if ($this->prix_max < 5000) {
            $query->where('prix', '<=', $this->prix_max);
        }
        if ($this->hauteur_min > 0) {
            $query->where('hauteur_cm', '>=', $this->hauteur_min);
        }
        if ($this->hauteur_max < 500) {
            $query->where('hauteur_cm', '<=', $this->hauteur_max);
        }
        if ($this->largeur_min > 0) {
            $query->where('largeur_cm', '>=', $this->largeur_min);
        }
        if ($this->largeur_max < 500) {
            $query->where('largeur_cm', '<=', $this->largeur_max);
        }
 
        $oeuvres = $query->paginate(24);
 
        // Listes pour les selects
        $categories = Categorie::orderBy('nom_categorie')->get();
        $themes     = Theme::where('type', 'theme')->orderBy('nom_theme')->get();
        $couleurs   = Couleur::orderBy('nom_couleur')->get();
 
        return view('livewire.artiste-galerie-filtres', compact(
            'oeuvres', 'categories', 'themes', 'couleurs'
        ));
    }
}
