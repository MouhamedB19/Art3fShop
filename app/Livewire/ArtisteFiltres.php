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

class ArtistIndex extends Component
{
    use WithPagination;
 
    // Filtres
    public string $search = '';
    public string $letter = '';
    public array $selectedDomains = [];
    public array $selectedCountries = [];
    public array $selectedSalons = [];
    public string $subscribeEmail = '';
    public bool $showSubscribeModal = false;
    public bool $subscribedSuccess = false;
 
    protected $queryString = [
        'search'          => ['except' => ''],
        'letter'          => ['except' => ''],
        'selectedDomains' => ['except' => []],
        'selectedCountries' => ['except' => []],
        'selectedSalons'  => ['except' => []],
    ];
    public function setLetter(string $letter): void
    {
        $this->letter = ($this->letter === $letter) ? '' : $letter;
        $this->resetPage();
    }
 
    public function clearAllFilters(): void
    {
        $this->reset(['search', 'letter', 'selectedDomains', 'selectedCountries', 'selectedSalons']);
        $this->resetPage();
    }
 
    public function toggleFavorite(int $artistId): void
    {
        if (! auth()->check()) {
            $this->dispatch('open-auth-modal');
            return;
        }
 
        $user = auth()->user();
 
        if ($user->favoriteArtists()->where('artist_id', $artistId)->exists()) {
            $user->favoriteArtists()->detach($artistId);
        } else {
            // Limite : 3 artistes coup de cœur max (cf CDC p.7)
            if ($user->favoriteArtists()->count() >= 3) {
                $this->dispatch('notify', type: 'warning', message: 'Vous ne pouvez pas suivre plus de 3 artistes.');
                return;
            }
            $user->favoriteArtists()->attach($artistId);
        }
    }
 
    public function subscribeToSearch(): void
    {
        $this->validate([
            'subscribeEmail' => 'required|email',
        ]);
 
        \App\Models\SearchSubscription::updateOrCreate(
            [
                'email'   => $this->subscribeEmail,
                'type'    => 'artists',
                'filters' => json_encode($this->activeFilters()),
            ]
        );
 
        $this->subscribedSuccess = true;
        $this->subscribeEmail    = '';
    }
 
    public function activeFilters(): array
    {
        return array_filter([
            'search'    => $this->search,
            'letter'    => $this->letter,
            'domains'   => $this->selectedDomains,
            'countries' => $this->selectedCountries,
            'salons'    => $this->selectedSalons,
        ]);
    }
 
    public function hasActiveFilters(): bool
    {
        return (bool) array_filter($this->activeFilters());
    }
 
    public function render()
    {
        $artists = Artiste::query()
            ->with(['categories', 'salons', 'featuredArtwork'])
            ->published()
            ->when($this->search, fn($q) =>
                $q->where('pseudonym', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%")
            )
            ->when($this->letter, fn($q) =>
                $q->where(function ($sub) {
                    $sub->where('nom_d_artiste', 'like', "{$this->letter}%")
                        ->orWhere('user.nom', 'like', "{$this->letter}%");
                })
            )
            ->when($this->selectedDomains, fn($q) =>
                $q->whereIn('category_id', $this->selectedDomains)
            )
            ->when($this->selectedCountries, fn($q) =>
                $q->whereIn('pays', $this->selectedCountries)
            )
            ->when($this->selectedSalons, fn($q) =>
                $q->whereHas('salons', fn($s) =>
                    $s->whereIn('art_salons.id', $this->selectedSalons)
                )
            )
            ->orderBy('nom_d_artiste')
            ->paginate(24);
 
        $featuredArtists = Artiste::query()
            ->sponsored()
            ->orderByRaw('RAND()')
            ->limit(6)
            ->get();
 
        $filterData = [
            'domains'   => Categorie::orderBy('nom_categorie')->get(['id', 'name']),
            'countries' => Artiste::published()->distinct()->orderBy('country')->pluck('country'),
            'salons'    => ArtSalon::orderByDesc('date')->get(['id', 'name', 'city']),
            'alphabet'  => range('A', 'Z'),
        ];
 
        $favoriteArtistIds = auth()->check()
            ? auth()->user()->favoriteArtists()->pluck('artist_id')->toArray()
            : [];
 
        return view('livewire.artistes-filtres', [
            'artists'          => $artists,
            'featuredArtists'  => $featuredArtists,
            'filterData'       => $filterData,
            'favoriteArtistIds' => $favoriteArtistIds,
        ]);
    }

} 
