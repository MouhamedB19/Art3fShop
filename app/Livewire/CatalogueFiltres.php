<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Oeuvre;
use App\Models\Categorie;
use App\Models\Theme;
use App\Models\Couleur;

class CatalogueFiltres extends Component
{
    use WithPagination;

    public ?int    $categorie_id  = null;
    public array   $theme_ids     = [];
    public array   $couleur_ids   = [];
    public ?bool   $encadrement   = null;
    public int     $prix_min      = 0;
    public int     $prix_max      = 5000;
    public ?string $orientation   = null;

    public function removeFiltre(string $type, mixed $value = null): void
    {
        match($type) {
            'categorie'   => $this->categorie_id = null,
            'orientation' => $this->orientation  = null,
            'encadrement' => $this->encadrement  = null,
            'prix'        => [$this->prix_min = 0, $this->prix_max = 5000],
            'theme'       => $this->theme_ids   = array_values(array_filter($this->theme_ids,   fn($id) => $id != $value)),
            'couleur'     => $this->couleur_ids = array_values(array_filter($this->couleur_ids, fn($id) => $id != $value)),
            default       => null,
        };
        $this->resetPage();
    }

    public function removeAllFiltres(): void
    {
        $this->reset(['categorie_id', 'theme_ids', 'couleur_ids', 'encadrement', 'prix_min', 'prix_max', 'orientation']);
        $this->prix_max = 5000;
        $this->resetPage();
    }

    public function hasFiltresActifs(): bool
    {
        return $this->categorie_id !== null
            || !empty($this->theme_ids)
            || !empty($this->couleur_ids)
            || $this->encadrement !== null
            || $this->orientation !== null
            || $this->prix_min > 0
            || $this->prix_max < 5000;
    }

    #[Computed]
    public function oeuvres()
    {
        return Oeuvre::query()
            ->where('visible', true)
            ->when($this->categorie_id, fn($q) =>
                $q->where('categorie_id', $this->categorie_id)
            )
            ->when($this->orientation, fn($q) =>
                $q->where('orientation', $this->orientation)
            )
            ->when(!empty($this->theme_ids), fn($q) =>
                $q->whereHas('themes', fn($q2) =>
                    $q2->whereIn('themes.id', $this->theme_ids)
                )
            )
            ->when(!empty($this->couleur_ids), fn($q) =>
                $q->whereHas('couleurs', fn($q2) =>
                    $q2->whereIn('couleurs.id', $this->couleur_ids)
                )
            )
            ->when($this->encadrement !== null, fn($q) =>
                $q->whereHas('tirages', fn($q2) =>
                    $q2->where('encadrement', $this->encadrement)
                )
            )
            ->when($this->prix_min > 0 || $this->prix_max < 5000, fn($q) =>
                $q->whereHas('tirages', fn($q2) =>
                    $q2->whereBetween('prix', [$this->prix_min, $this->prix_max])
                )
            )
            ->with(['artiste.user', 'categorie', 'tirages.dimension'])
            ->latest()
            ->paginate(18);
    }

    public function render()
    {
        return view('livewire.catalogue-filtres', [
            'categories' => Categorie::whereNull('id_categorie_parente')->get(),
            'themes'     => Theme::orderBy('nom_theme')->get(),
            'couleurs'   => Couleur::orderBy('nom_couleur')->get(),
            'oeuvres' => $this->oeuvres,
        ]);
    }
}
