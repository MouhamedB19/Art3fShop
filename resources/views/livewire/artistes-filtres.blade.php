<?php
 
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Artiste;
use App\Models\Categorie;
use App\Models\Pays;
use App\Models\Oeuvre;
 
new class extends Component
{
    use WithPagination;
 
    public string  $recherche    = '';
    public ?int    $pays_id      = null;
    public ?int    $categorie_id = null;
    public string  $lettre       = '';
 
    
    public function setLettre(string $lettre): void
    {
        $this->lettre = $this->lettre === $lettre ? '' : $lettre;
        $this->resetPage();
    }
 
    public function removeAllFiltres(): void
    {
        $this->reset(['recherche', 'pays_id', 'categorie_id', 'lettre']);
        $this->resetPage();
    }
 
    public function hasFiltresActifs(): bool
    {
        return $this->recherche !== ''
            || $this->pays_id !== null
            || $this->categorie_id !== null
            || $this->lettre !== '';
    }
 
    #[Computed]
    public function artistes()
    {
        return Artiste::query()
            ->whereHas('user')
            ->when($this->recherche, fn($q) =>
                $q->where('nom_d_artiste', 'like', "%{$this->recherche}%")
                  ->orWhereHas('user', fn($q2) =>
                      $q2->where('nom', 'like', "%{$this->recherche}%")
                         ->orWhere('prenom', 'like', "%{$this->recherche}%")
                  )
            )
            ->when($this->lettre, fn($q) =>
                $q->where(function($q2) {
                    $q2->where('nom_d_artiste', 'like', "{$this->lettre}%")
                       ->orWhereHas('user', fn($q3) =>
                           $q3->where('nom', 'like', "{$this->lettre}%")
                       );
                })
            )
            ->when($this->pays_id, fn($q) =>
                $q->whereHas('localisation.ville', fn($q2) =>
                    $q2->where('pays_id', $this->pays_id)
                )
            )
            ->when($this->categorie_id, fn($q) =>
                $q->whereHas('categories', fn($q2) =>
                    $q2->where('categories.id', $this->categorie_id)
                )
            )
            ->with(['user', 'localisation.ville.pays', 'oeuvres' => fn($q) =>
                $q->where('visible', true)->with('tirages')->latest()->take(1)
            ])
            ->paginate(18);
    }
 
    public function with(): array
    {
        return [
            'categories' => Categorie::whereNull('id_categorie_parente')->get(),
            'pays'       => Pays::orderBy('nom_pays')->get(),
            'lettres'    => range('A', 'Z'),
        ];
    }
}; 
?>

<div>
  
    {{-- ═══════════════════════════════════════════════════
         BARRE DE FILTRES
         ═══════════════════════════════════════════════════ --}}
    <div class="bg-white border-b border-gray-200 sticky top-[4rem] z-40">
        <div class="max-w-screen-xl mx-auto px-4 py-3 space-y-3">
 
            {{-- Ligne 1 : recherche + filtres --}}
            <div class="flex flex-wrap items-center gap-3">
 
                {{-- Recherche --}}
                <div class="relative flex-1 min-w-[200px] max-w-xs">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text"
                           wire:model.live.debounce="recherche"
                           placeholder="Nom d'un artiste..."
                           class="w-full pl-9 pr-4 py-1.5 text-sm border border-gray-300 rounded-lg
                                  focus:outline-none focus:ring-2 focus:ring-[#E8490F]
                                  focus:border-transparent transition-all"
                    >
                </div>
 
                {{-- Domaine --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-sm border rounded-lg
                                   hover:border-[#E8490F] transition-colors
                                   {{ $categorie_id ? 'border-[#E8490F] bg-orange-50 text-[#E8490F] font-semibold' : 'border-gray-300 text-gray-700' }}">
                        Domaine
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                                rounded-xl shadow-xl z-50 p-2 min-w-[180px]">
                        <button wire:click="$set('categorie_id', null)"
                                class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                       hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                       {{ !$categorie_id ? 'font-bold text-[#E8490F]' : '' }}">
                            Tous les domaines
                        </button>
                        @foreach($categories as $cat)
                            <button wire:click="$set('categorie_id', {{ $cat->id }})"
                                    class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                           hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                           {{ $categorie_id == $cat->id ? 'font-bold text-[#E8490F]' : '' }}">
                                {{ $cat->nom_categorie }}
                            </button>
                        @endforeach
                    </div>
                </div>
 
                {{-- Pays --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-sm border rounded-lg
                                   hover:border-[#E8490F] transition-colors
                                   {{ $pays_id ? 'border-[#E8490F] bg-orange-50 text-[#E8490F] font-semibold' : 'border-gray-300 text-gray-700' }}">
                        Pays
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                                rounded-xl shadow-xl z-50 p-2 min-w-[180px] max-h-64 overflow-y-auto">
                        <button wire:click="$set('pays_id', null)"
                                class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                       hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                       {{ !$pays_id ? 'font-bold text-[#E8490F]' : '' }}">
                            Tous les pays
                        </button>
                        @foreach($pays as $p)
                            <button wire:click="$set('pays_id', {{ $p->id }})"
                                    class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                           hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                           {{ $pays_id == $p->id ? 'font-bold text-[#E8490F]' : '' }}">
                                {{ $p->nom_pays }}
                            </button>
                        @endforeach
                    </div>
                </div>
 
                {{-- Compteur + reset --}}
                <div class="flex items-center gap-3 ml-auto">
                    <span class="text-xs text-gray-400">
                        {{ $this->artistes->total() }} artiste{{ $this->artistes->total() > 1 ? 's' : '' }}
                    </span>
                    @if($this->hasFiltresActifs())
                        <button wire:click="removeAllFiltres"
                                class="text-xs text-red-500 hover:text-red-700 underline transition-colors">
                            Réinitialiser
                        </button>
                    @endif
                </div>
 
            </div>
 
            {{-- Ligne 2 : filtre alphabétique --}}
            <div class="flex flex-wrap items-center gap-1">
                <span class="text-xs text-gray-400 mr-2">Nom :</span>
                @foreach($lettres as $l)
                    <button wire:click="setLettre('{{ $l }}')"
                            class="w-7 h-7 text-xs font-semibold rounded-lg transition-colors
                                   {{ $lettre === $l
                                       ? 'bg-[#1A1A1A] text-white'
                                       : 'text-gray-500 hover:bg-gray-100 hover:text-[#E8490F]' }}">
                        {{ $l }}
                    </button>
                @endforeach
            </div>
 
        </div>
    </div>
 
    {{-- ═══════════════════════════════════════════════════
         GRILLE ARTISTES
         ═══════════════════════════════════════════════════ --}}
    <div class="max-w-screen-xl mx-auto px-4 py-10">
 
        @if($this->artistes->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($this->artistes as $artiste)
                    @php
                        $nom        = $artiste->nom_d_artiste ?? $artiste->user->nom . ' ' . $artiste->user->prenom;
                        $ville      = $artiste->localisation?->ville?->nom_ville;
                        $pays       = $artiste->localisation?->ville?->pays?->nom_pays;
                        $oeuvrePhoto = $artiste->oeuvres->first()?->photo_principale;
                        $nombreOeuvres = Oeuvre::where('artiste_id',$artiste->id)->where('visible',1)->count();
                    @endphp
 
                    <a href="{{ route('artistes.show', $artiste->id) }}"
                       class="group block bg-white rounded-2xl overflow-hidden shadow-sm
                              hover:shadow-xl transition-shadow duration-300">
 
                        {{-- Photo de l'œuvre (fond de carte) --}}
                        <div class="relative h-52 bg-gray-100 overflow-hidden">
                            @if($oeuvrePhoto)
                                <img src="{{ asset('storage/' . $oeuvrePhoto) }}"
                                     alt="Œuvre de {{ $nom }}"
                                     class="w-full h-full object-cover transition-transform
                                            duration-500 group-hover:scale-105"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br
                                            from-gray-200 to-gray-300 flex items-center
                                            justify-center">
                                    <span class="text-5xl font-black text-gray-400">
                                        {{ strtoupper(substr($nom, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
 
                            {{-- Overlay hover --}}
                            <div class="absolute inset-0 bg-black/50 opacity-0
                                        group-hover:opacity-100 transition-opacity duration-300
                                        flex items-center justify-center">
                                <span class="text-white text-sm font-bold border border-white/50
                                             px-4 py-2 rounded-lg">
                                    Découvrir sa page
                                </span>
                            </div>
 
                            {{-- Photo de profil --}}
                            <div class="absolute bottom-3 left-3">
                                @if($artiste->photo)
                                    <img src="{{ asset('storage/' . $artiste->photo) }}"
                                         alt="{{ $nom }}"
                                         class="w-10 h-10 rounded-full object-cover border-2
                                                border-white shadow-md">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#1A1A1A] border-2
                                                border-white shadow-md flex items-center
                                                justify-center text-white text-sm font-bold">
                                        {{ strtoupper(substr($nom, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
 
                            {{-- Picto art3f --}}
                            @if($artiste->Est_Artiste_Art3f)
                                <div class="absolute top-2 right-2 w-2 h-2 rounded-full
                                            bg-[#E8490F] shadow-md"></div>
                            @endif
 
                        </div>
 
                        {{-- Infos --}}
                        <div class="p-4">
                            <h3 class="font-bold text-[#1A1A1A] truncate group-hover:text-[#E8490F]
                                       transition-colors">
                                {{ $nom }}
                            </h3>
                            @if($ville || $pays)
                                <p class="text-xs text-gray-400 mt-0.5 truncate">
                                    {{ collect([$ville, $pays])->filter()->implode(', ') }}
                                </p>
                            @endif
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-gray-400">
                                    {{ $nombreOeuvres }}
                                    œuvre{{ $nombreOeuvres > 1 ? 's' : '' }}
                                </p>
                                @if($artiste->Est_Artiste_Art3f)
                                    <span class="text-[10px] text-[#E8490F] font-semibold
                                                 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#E8490F]"></span>
                                        art3f
                                    </span>
                                @endif
                            </div>
                        </div>
 
                    </a>
                @endforeach
            </div>
 
            {{-- Pagination --}}
            <div class="mt-12">
                {{ $this->artistes->links() }}
            </div>
 
        @else
            <div class="text-center py-24">
                <p class="text-xl font-bold text-gray-300">Aucun artiste trouvé</p>
                <p class="text-sm text-gray-400 mt-2">Essayez d'élargir votre recherche</p>
                <button wire:click="removeAllFiltres"
                        class="mt-6 px-6 py-2.5 bg-[#E8490F] text-white text-sm font-bold
                               rounded-lg hover:bg-orange-600 transition-colors">
                    Réinitialiser les filtres
                </button>
            </div>
        @endif
 
    </div>
 
    {{-- Indicateur de chargement --}}
    <div wire:loading.flex
         class="fixed inset-0 bg-white/60 z-50 items-center justify-center">
        <svg class="animate-spin w-8 h-8 text-[#E8490F]" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
    </div>
 
</div>